<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Damage;
use App\Entity\Guest;
use App\Entity\Inventory;
use App\Entity\Occupancy;
use App\Entity\Parking;
use App\Entity\Payment;
use App\Entity\Price;
use App\Entity\Room;
use App\Form\BookingType;
use App\Form\DamageType;
use App\Form\GuestType;
use App\Form\InventoryType;
use App\Form\OccupancyType;
use App\Form\ParkingType;
use App\Form\PaymentType;
use App\Form\PriceType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/checkout/{bookingid}", name="checkout")
     */
    public function checkout(Request $request)
    {
        $bookingID = $request->attributes->get('bookingid');
        $entityManager = $this->getDoctrine()->getManager();
        $booking = $entityManager->getRepository(Booking::class)->find($bookingID);
//        dump($booking);
//        die('im C');
        $form = $this->createForm(BookingType::class, $booking);
        return $this->render('booking/checkout.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
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
