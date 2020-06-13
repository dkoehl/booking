<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Damage;
use App\Entity\Deposite;
use App\Entity\Guest;
use App\Entity\Inventory;
use App\Entity\Occupancy;
use App\Entity\Parking;
use App\Entity\Payment;
use App\Entity\Price;
use App\Entity\Room;
use App\Form\BookingType;
use App\Form\DamageType;
use App\Form\DepositeType;
use App\Form\GuestType;
use App\Form\InventoryType;
use App\Form\OccupancyType;
use App\Form\ParkingType;
use App\Form\PaymentType;
use App\Form\PriceType;
use App\Repository\BookingRepository;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="booking_index", methods={"GET"})
     * @param BookingRepository $bookingRepository
     * @return Response
     * @throws \Exception
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->showBookingsInFuture(),
            'bookingsCheckInsToday' => $bookingRepository->findCheckinsToday(),
            'bookingsCheckOutsToday' => $bookingRepository->findCheckOutsToday()
        ]);
    }


    /**
     * @Route("/getvacanciesbydate/{bookingfrom}/{bookingtill}/{roomType}", name="getvacanciesbydate")
     * @param Request $request
     * @return JsonResponse
     */
    public function getVacanciesbydate(Request $request): JsonResponse
    {
//        $bookingFrom = '2019-05-01';
//        $bookingTill = '2019-05-30';

        $requestUri = explode('/', $request->getRequestUri());
        $bookingFrom = $requestUri[3];
        $bookingTill = $requestUri[4];
        // gets all bookings
        $rentedRoomIds = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->getVacanciesbydate($bookingFrom, $bookingTill);
        if (!empty($rentedRoomIds)) {
            $freeRooms = $this->getDoctrine()
                ->getRepository(Room::class)
                ->getFreeRooms($rentedRoomIds);
        } else {
            // no bookings
            $freeRooms = $this->getDoctrine()
                ->getRepository(Room::class)
                ->findAll();
        }

        /**
         * @todo: check this function again, soon!
         */
        foreach ($freeRooms as $room) {
            if ($room->getHidden() === true || $room->getDeleted() === true) {
                continue;
            }
            // checkt auf EINZELZIMMER
            if ($requestUri[5] === '1') {
                if ($room->getBeds() != '1') {
                    continue;
                }
            }
            // checkt auf MEHRBETTZIMMER
            if ($requestUri[5] === '2') {
                if ($room->getBeds() === '1') {
                    continue;
                }
            }
            $freeRoomsArray[] = [
                'id' => $room->getId(),
                'name' => $room->getName(),
                'beds' => $room->getBeds(),
                'floor' => $room->getFloor(),
                'house' => $room->getHouse()
            ];
        }

        return $this->json($freeRoomsArray);
    }


    /**
     * @Route("/checkout/sendfiles", name="checkout_sendpdfs", methods={"POST"})
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function sendPDFFiles(
        Request $request,
        \Swift_Mailer $mailer
    ): JsonResponse {
        $postData = $request->getContent();
        $formData = json_decode($postData, true);
        // if no formdata available
        // builds array for pdf merging
        foreach($formData as $formKey => $formValue){
            if(!in_array($formKey, ['receiver', 'subject', 'bodytext'])){
                $pdfs[$formKey] = $formValue;
            }
        }
        $pdfFileObject = $this->mergeGeneratedPdfs($pdfs, $pdfs['bookingid']);
        $pdfFileArray = json_decode($pdfFileObject->getContent());


        $entityManager = $this->getDoctrine()->getManager();
        $booking = $entityManager->getRepository(Booking::class)
            ->find($formData['bookingid']);

        $message = (new \Swift_Message($formData['subject']))
            ->setFrom('no-reply@boardinghouse-neufahrn.de')
            ->setTo($formData['receiver'])
            ->setBody($formData['bodytext'])
            ->addPart(
                $this->renderView(
                    'booking/_booking_body_small.html.twig',
                    ['booking' => $booking]
                ),
                'text/plain'
            );
        if (isset($pdfFileArray[0])) {
            $message->attach(\Swift_Attachment::fromPath(
                __DIR__ . '/../../public/' . $pdfFileArray[0]
            ));
        }
        $mailer->send($message);

        return $this->json([
            'generating' => true
        ]);
    }

    /**
     * @Route("/printpdfs", name="booking_printpdfs", methods={"POST"})
     * @param Request $request
     */
    public function printPdfs(Request $request)
    {
        $postData = $request->getContent();
        $pdfs = json_decode($postData, true);
        $response = $this->mergeGeneratedPdfs($pdfs, $pdfs['bookingid']);

        return $response;
    }
    /**
     * @Route("/checkout/generatepdfs", name="checkout_generatepdfs", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function checkoutGeneratePDFs(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $booking = $entityManager->getRepository(Booking::class)
            ->find($requestData['bookingid']);

        $this->generateRegistrationCertificate($booking);


        return $this->json([
            'generating' => true
        ]);
    }


    /**
     * @Route("/checkout/{bookingid}", name="checkout")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return Response
     * @throws PdfReaderException
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function checkout(Request $request, \Swift_Mailer $mailer): Response
    {
        $bookingID = $request->attributes->get('bookingid');
        $entityManager = $this->getDoctrine()->getManager();
        $booking = $entityManager->getRepository(Booking::class)->find($bookingID);
        // copies default pdfs in output folder
        $this->copyUneditedPdfs($booking);
        // generates pdfs
        $this->generateRegistrationCertificate_PDF($booking);
        $this->generateAufnahmevertrag_PDF($booking);
        //@todo: add inventory list pdf functions
//        $this->generateInventorylist_PDF($booking);
        // merge generated pdfs
//        $this->mergeGeneratedPdfs($booking);


//        dump($booking);
//        die('im C');
        return $this->render('booking/checkout.html.twig', [
            'booking' => $booking
        ]);
    }




    /**
     * Merges selected PDFs into one PDF
     *
     * @param $pdfs
     * @return JsonResponse
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfReaderException
     * @throws PdfTypeException
     */
    public function mergeGeneratedPdfs($pdfs)
    {
        $pdfFolder = __DIR__ . '/../../public/documents/' . $pdfs['bookingid'] . '/';
        $pdfArray = [
            'agbs' => '_Datenschutzerklaerung.pdf',
            'contract' => date('Y-m-d') . '-HSN_Aufnahmevertrag_Muster_06.2019-' . $pdfs['bookingid'] . '.pdf',
            'meldeschein' => date('Y-m-d') . '-meldeschein-' . $pdfs['bookingid'] . '.pdf',
//            'inventory' => '',
            'pricelist' => '_Preisliste.pdf',
            'houserules' => '_Hausordnung.pdf'
        ];
        $allPdfsInFolder = [];
        foreach ($pdfs as $key => $value) {
            if ($key === 'bookingid' || $key === 'inventory') {
                continue;
            }
            $allPdfsInFolder[] = $pdfArray[$key];
        }

        $pdf = new Fpdi();
        foreach ($allPdfsInFolder as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            // get the page count
            $pageCount = $pdf->setSourceFile($pdfFolder . $file);
            // iterate through all pages
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                // get the size of the imported page
                $size = $pdf->getTemplateSize($templateId);
                // create a page (landscape or portrait depending on the imported page size)
                if ($size['width'] > $size['height']) {
                    $pdf->AddPage('L', array($size['width'], $size['height']));
                } else {
                    $pdf->AddPage('P', array($size['width'], $size['height']));
                }

                // use the imported page
                $pdf->useTemplate($templateId);
            }
        }
        // output merged pdf file
        $pdf->Output('F',
            $pdfFolder . date('Y-m-d') . '_Booking-selected-documents_' . $pdfs['bookingid'] . '.pdf');

        return $this->json(
            [
                '/documents/' . $pdfs['bookingid'] . '/' . date('Y-m-d') . '_Booking-selected-documents_' . $pdfs['bookingid'] . '.pdf'
            ]
        );
    }


    /**
     * copies default (not edited) pdf in export folder for printing js
     *
     * @param $booking
     */
    public function copyUneditedPdfs(&$booking)
    {
        $defaultPdfStoragePath = __DIR__ . '/../../assets/pdfs/';
        $targetFolder = __DIR__ . '/../../public/documents/' . $booking->getId() . '/';
        $defaultPDFs = [
            '_Datenschutzerklaerung.pdf',
            '_Hausordnung.pdf',
            '_Preisliste.pdf'
        ];
        foreach ($defaultPDFs as $pdf) {
            if (!@mkdir($concurrentDirectory = $targetFolder) && !@is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            copy($defaultPdfStoragePath . $pdf, $targetFolder . $pdf);
        }
    }

    /**
     * PDF: Generates Aufnahmevertrag PDF
     *
     * @param Booking $booking
     * https://www.setasign.com/products/fpdi/demos/simple-demo/#p-329.6000061035156
     * @throws PdfReaderException
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function generateAufnahmevertrag_PDF(&$booking): void
    {
//        die(
//        dump($booking->getBookedroom()->getBeds())
//        );

        $pdf = new Fpdi();
        $pdf->setSourceFile(__DIR__ . '/../../assets/pdfs/HSN_Aufnahmevertrag_Muster_06.2019.pdf');
        $firstPage = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($firstPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');

        // Set Company name
        $pdf->SetXY(82, 131);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getGuest()->getCompanyname());
        // Set Lastname, Firstname
        $pdf->SetXY(82, 145);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getGuest()->getLastnameFirstname());
        // Set Street
        $pdf->SetXY(82, 159);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getGuest()->getAddress());
        // Set Zip City
        $pdf->SetXY(82, 173);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getGuest()->getZipcode() . ' ' . $booking->getGuest()->getCity());
        // Set Birthday
        $pdf->SetXY(82, 187);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getGuest()->getBirthday()->format('d.m.Y'));
        // Set Birthday
        $pdf->SetXY(82, 201);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getGuest()->getPlaceofbirth());
        /**
         * Second Page
         */
        $secondPage = $pdf->importPage(2);
        $pdf->AddPage();
        $pdf->useTemplate($secondPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');
        // Set Room
        $pdf->SetXY(36, 42);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getBookedroom()->getHouseName());
        // Set Booking from
        $pdf->SetXY(154, 171);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getBookingfrom()->format('d.m.Y'));
        // Set Booking from
        $pdf->SetXY(31, 178);
        $pdf->SetFontSize('11');
        $pdf->Write(5, $booking->getBookingtill()->format('d.m.Y'));
        /**
         * Third Page
         */
        $thirdPage = $pdf->importPage(3);
        $pdf->AddPage();
        $pdf->useTemplate($thirdPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');
        // Set Price
        #// @todo: check for real prices
//        die(
//            dump($booking->getPrice()[0]->getType())
//        );
        // Einzelzimmer und monatliche Bezahlung
        if ($booking->getBookedroom()->getBeds() > '1' && $booking->getPrice()[0]->getType() === '2') {
            $pdf->SetXY(140, 102);
        }
        if ($booking->getBookedroom()->getBeds() === '1' && $booking->getPrice()[0]->getType() === '2') {
            $pdf->SetXY(140, 120);
        }
        // Einzelzimmer und täglich Bezahlung
        if ($booking->getBookedroom()->getBeds() === '1' && $booking->getPrice()[0]->getType() === '1') {
            $pdf->SetXY(140, 162);
        }
        if ($booking->getBookedroom()->getBeds() > '1' && $booking->getPrice()[0]->getType() === '1') {
            $pdf->SetXY(140, 137);
        }
        $pdf->SetFontSize('11');
        $pdf->Write(5, 'EUR ' . $booking->getPrice()[0]->getPrice() . ',00');

        $fourthPage = $pdf->importPage(4);
        $pdf->AddPage();
        $pdf->useTemplate($fourthPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');

        $fifthPage = $pdf->importPage(5);
        $pdf->AddPage();
        $pdf->useTemplate($fifthPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');
        /**
         * Sixth Page
         */
        $sixthPage = $pdf->importPage(6);
        $pdf->AddPage();
        $pdf->useTemplate($sixthPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');
        // Set Parking
//        dump($booking->getParking()[0]);
//        die('3');
        if ($booking->getParkings()[0] !== null) {
            $pdf->SetXY(99, 231.5);
            $pdf->SetFontSize('11');
            $pdf->Write(5, $booking->getParkings()[0]->getParkingspot());
        }
        /**
         * Seventh Page
         */
        $seventhPage = $pdf->importPage(7);
        $pdf->AddPage();
        $pdf->useTemplate($seventhPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');
        // Set Parking
        if ($booking->getParkings()[0] !== null) {
            $pdf->SetXY(115, 22);
            $pdf->SetFontSize('11');
            $pdf->Write(5, $booking->getParkings()[0]->getParkingspot());
        }
        /**
         * Eigth Page
         */
        $eighthPage = $pdf->importPage(8);
        $pdf->AddPage();
        $pdf->useTemplate($eighthPage, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');
        // Set Date
        $pdf->SetXY(52, 149.5);
        $pdf->SetFontSize('11');
        $pdf->Write(5, date('d.m.Y'));
        // Set Date
//        $pdf->SetXY(140, 149.5);
//        $pdf->SetFontSize('11');
//        $pdf->Write(5, date('d.m.Y'));


        // make folder
        if (!@mkdir($concurrentDirectory = __DIR__ . '/../../public/documents/' . $booking->getId()) && !@is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        // Output the new PDF
        $pdf->Output('F',
            $concurrentDirectory . '/' . date('Y-m-d') . '-HSN_Aufnahmevertrag_Muster_06.2019-' . $booking->getId() . '.pdf');
    }


    /**
     * PDF: Generates Inventory List
     *
     * https://www.setasign.com/products/fpdi/demos/simple-demo/#p-329.6000061035156
     * @param $booking
     * @throws PdfReaderException
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function generateInventorylist_PDF(&$booking): void
    {
        $pdf = new Fpdi();
        $pdf->setSourceFile(__DIR__ . '/../../assets/pdfs/Inventarliste.pdf');
        $templateId = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');

        // Set From
        $pdf->SetXY(98, 24);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getBookingfrom()->format('d.m.Y'));


        // make folder
        if (!@mkdir($concurrentDirectory = __DIR__ . '/../../public/documents/' . $booking->getId()) && !@is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        // Output the new PDF
        $pdf->Output('F', $concurrentDirectory . '/' . date('Y-m-d') . '-meldeschein-' . $booking->getId() . '.pdf');
    }

    /**
     * PDF: Generates Registration PDF
     *
     * @param Booking $booking
     * @throws PdfParserException
     * @throws PdfReaderException
     *
     * @todo: entity guest um felder erweitern, siehe meldeschein pdf
     */
    public function generateRegistrationCertificate_PDF(&$booking): void
    {
        if (empty($booking)) {
            return;
        }
//        dump($booking->getGuest()->getId());
        $pdf = new Fpdi();
        $pdf->setSourceFile(__DIR__ . '/../../assets/pdfs/Meldeschein.pdf');
        $templateId = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
        $pdf->SetFont('Helvetica');

        // Set Room
        $pdf->SetXY(125, 14);
        $pdf->SetFontSize('9');
        $pdf->Write(1,
            $booking->getBookedroom()->getName() . ' ' . $booking->getBookedroom()->getHouse() . ' ' . $booking->getBookedroom()->getFloor());
        // Set From
        $pdf->SetXY(98, 24);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getBookingfrom()->format('d.m.Y'));
        // Set till
        $pdf->SetXY(163, 24);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getBookingtill()->format('d.m.Y'));
        // Set Guest name
        $pdf->SetXY(72, 32);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getLastnameFirstname());
        // Set Street
        $pdf->SetXY(72, 37);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getStreet());
        // Set City
        $pdf->SetXY(72, 42);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getZipcode() . ' ' . $booking->getGuest()->getCity());
        // Set Country
        $pdf->SetXY(163, 42);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getCountry());
        // Set Birthday
        $pdf->SetXY(72, 54);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getBirthday()->format('d.m.Y'));
        // Set Occupancies
        $pdf->SetXY(163, 54);
        $pdf->SetFontSize('9');
        $pdf->Write(5, count($booking->getOccupancies()) + 1);
        /**
         * Company settings
         */
        // Set Company
        $pdf->SetXY(72, 94.5);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getCompanyname());
        // Set Company
        $pdf->SetXY(72, 94.5);
        $pdf->SetFontSize('9');
        $pdf->Write(5, $booking->getGuest()->getCompanyname());
        // make folder
        if (!@mkdir($concurrentDirectory = __DIR__ . '/../../public/documents/' . $booking->getId()) && !@is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        // Output the new PDF
        $pdf->Output('F', $concurrentDirectory . '/' . date('Y-m-d') . '-meldeschein-' . $booking->getId() . '.pdf');
    }


    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        $requestReg = $request->request->get('booking');

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // sets room
            /**
             * @todo: check this function, no multiple rooms possible
             */
            if (is_array($requestReg['room'])) {
                foreach ($requestReg['room'] as $roomId) {
                    $room = $this->getDoctrine()
                        ->getRepository(Room::class)
                        ->findOneBy(['id' => $roomId]);
                    $booking->setBookedroom($room);
                    $booking->addRoom($room);
                }
            }
            // Sets guest
            /**
             * @todo: check this function, no multiple guests possible
             */
            if (isset($requestReg['guest'])) {
                $guest = $this->getDoctrine()
                    ->getRepository(Guest::class)
                    ->findOneBy(['id' => $requestReg['guest']]);
                $booking->setGuest($guest);
            }
            $booking->setBookingfrom(\DateTime::createFromFormat('Y-m-d H:i:s',
                date('Y-m-d H:i:s', strtotime($requestReg['bookingfrom']))));
            $booking->setBookingtill(\DateTime::createFromFormat('Y-m-d H:i:s',
                date('Y-m-d H:i:s', strtotime($requestReg['bookingtill']))));
            $booking->setTstamp(time());
            $booking->setHidden(0);
            $booking->setDeleted(0);
            $booking->setCrdate(time());
            $entityManager->persist($booking);

            $entityManager->flush();
            $newBookingID = $booking->getId();
            return $this->redirectToRoute('booking_show', ['id' => $newBookingID]);
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        $room = $this->getDoctrine()
            ->getRepository(Room::class)
            ->findOneBy(['id' => $booking->getBookedroom()]);

        $guestForm = $this->createForm(GuestType::class, new Guest());
        $occupancyForm = $this->createForm(OccupancyType::class, new Occupancy());
        $priceForm = $this->createForm(PriceType::class, new Price());
        $paymentForm = $this->createForm(PaymentType::class, new Payment());
        $parkingForm = $this->createForm(ParkingType::class, new Parking());
        $inventoryForm = $this->createForm(InventoryType::class, new Inventory());
        $damageForm = $this->createForm(DamageType::class, new Damage());
        $roomForm = $this->createForm(DamageType::class, new Damage());
        $depositeForm = $this->createForm(DepositeType::class, new Deposite());
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'room' => $roomForm->createView(),
            'guestForm' => $guestForm->createView(),
            'occupancyForm' => $occupancyForm->createView(),
            'priceForm' => $priceForm->createView(),
            'paymentForm' => $paymentForm->createView(),
            'parkingForm' => $parkingForm->createView(),
            'inventoryForm' => $inventoryForm->createView(),
            'damageForm' => $damageForm->createView(),
            'depositeForm' => $depositeForm->createView(),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     *
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_index', [
                'id' => $booking->getId(),
            ]);
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index');
    }


}