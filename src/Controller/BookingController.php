<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Damage;
use App\Entity\Guest;
use App\Entity\Inventory;
use App\Entity\Parking;
use App\Entity\Payment;
use App\Entity\Price;
use App\Entity\Room;
use App\Form\BookingType;
use App\Form\DamageType;
use App\Form\GuestType;
use App\Form\RoomType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     * @Route("/getvacanciesbydate/{bookingfrom}/{bookingtill}", name="getvacanciesbydate")
     */
    public function getVacanciesbydate(Request $request)
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
        }else{
            // no bookings
            $freeRooms = $this->getDoctrine()
                ->getRepository(Room::class)
                ->findAll();
        }

        /**
         * @todo: check this function again, soon!
         */
        foreach ($freeRooms as $room) {
            if (!$room->getHidden() && !$room->getDeleted()) {
                $freeRoomsArray[] = [
                    'id' => $room->getId(),
                    'name' => $room->getName(),
                    'beds' => $room->getBeds(),
                    'floor' => $room->getFloor(),
                    'house' => $room->getHouse()
                ];
            }
        }

        return $this->json($freeRoomsArray);
    }


    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
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
        $roomForm = $this->createForm(RoomType::class, new Room());

        $price = new Price();
        $priceForm = $this->createFormBuilder($price)
            ->add('type', TextType::class)
            ->add('price', TextType::class)
            ->add('tax', TextType::class)
            ->add('amount', TextType::class)
            ->add('prices', TextType::class)
            ->getForm();
        $damage = new Damage();
        $damageForm = $this->createFormBuilder($damage)
            ->add('damageart', ChoiceType::class, [
                'choices' => [
                    'Please choose' => null,
                    'Small damage' => 'Small damage',
                    'Middle damage' => 'Middle damage',
                    'Full damage' => 'Full damage',
                ],
            ])
            ->add('damagetext', TextareaType::class)
            ->add('price', TextType::class)
            ->add('damage', TextareaType::class)
            ->getForm();
        $inventory = new Inventory();
        $inventoryForm = $this->createFormBuilder($inventory)
            ->add('beds', IntegerType::class)
            ->add('closets', IntegerType::class)
            ->add('tables', IntegerType::class)
            ->add('chairs', IntegerType::class)
            ->add('floor', TextType::class)
            ->add('walls', TextType::class)
            ->add('windows', IntegerType::class)
            ->add('doors', IntegerType::class)
            ->add('roomsspecial', TextareaType::class)
            ->getForm();
        $payment = new Payment();
        $paymentForm = $this->createFormBuilder($payment)
            ->add('payment', IntegerType::class)
            ->add('number', TextType::class)
            ->add('securitynumber', TextType::class)
            ->getForm();
        $parking = new Parking();
        $parkingForm = $this->createFormBuilder($parking)
            ->add('carplate', TextType::class)
            ->add('startdate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'placeholder' => 'dd.mm.YYYY',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'From:',
            ])
            ->add('enddate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'placeholder' => 'dd.mm.YYYY',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'To:',
            ])
            ->getForm();

        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'room' => $room,
            'guestForm' => $guestForm->createView(),
            'priceForm' => $priceForm->createView(),
            'damageForm' => $damageForm->createView(),
            'inventoryForm' => $inventoryForm->createView(),
            'paymentForm' => $paymentForm->createView(),
            'parkingForm' => $parkingForm->createView(),

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
