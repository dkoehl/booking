<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }


    /**
     * @Route("/showAllBookingsChart", name="showAllBookingsChart")
     */
    public function showAllBookingsChart()
    {
        $allBookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findAll();
        $daysOfThisMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $yearAndMonth = date('Y-m');

        $dayBookingArray = [];
        $searchDates = [];
        for ($i = 1; $i <= $daysOfThisMonth; $i++) {
            $day = $i;
            if (strlen($day) === 1) {
                $day = '0' . $day;
            }
            $searchDate = $yearAndMonth . '-' . $day;

            $bookingsHits = [];
            foreach ($allBookings as $booking) {
                $bookingDateFrom = $booking->getBookingfrom()->format('Y-m-d');
                $bookingDateTill = $booking->getBookingtill()->format('Y-m-d');

                if (($searchDate >= $bookingDateFrom) && ($searchDate <= $bookingDateTill)) {
                    $bookingsHits[] = $booking;

                }

            }
            $dayBookingArray[] = count($bookingsHits);
            $searchDates[] = $searchDate;
        }
        return $this->json(['dates' => $searchDates, 'bookings' => $dayBookingArray]);

    }

    /**
     * @Route("/showBookedRooms", name="showBookedRooms")
     */
    public function showBookedRooms()
    {
        $allRooms = $this->getDoctrine()
            ->getRepository(Room::class)
            ->findAll();

        $allBookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findAll();

        $rooms = count($allRooms);
        $bookings = count($allBookings);

        $freeRooms = $rooms - $bookings;

        return $this->json(['rooms' => $rooms, 'bookings' => $bookings, 'free' => $freeRooms]);
    }

    /**
     * @Route("/showBookedRoomsbymonth", name="showBookedRoomsbymonth")
     */
    public function showBookedRoomsbymonth()
    {
        $allBookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->showBookedRoomsbymonth();
        $allRooms = $this->getDoctrine()
            ->getRepository(Room::class)
            ->findAll();

        $rooms = count($allRooms);
        $bookings = count($allBookings);

        $freeRooms = $rooms - $bookings;

        return $this->json(['rooms' => $rooms, 'bookings' => $bookings, 'free' => $freeRooms]);
    }

    /**
     * @Route("/showallguests", name="showallguests")
     */
    public function showCountAllGuests()
    {
        $allGuests = $this->getDoctrine()
            ->getRepository(Guest::class)
            ->findAll();

        $allGuestCount = count($allGuests);
        return $this->json(['guests' => $allGuestCount]);
    }

}
