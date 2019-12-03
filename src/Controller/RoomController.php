<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/room")
 */
class RoomController extends AbstractController
{

    /**
     * @Route("/overview")
     */
    public function overview(RoomRepository $roomRepository)
    {
        $rooms = $roomRepository->findAll();
        $occunciesArray = [];
        foreach ($rooms as $room) {
            if ($room->getHidden() || $room->getDeleted()) {
                continue;
            }
            if ($room->getBookings()) {
                foreach ($room->getBookings() as $booking) {
                    $dateToday = new \DateTime();
            
                    if ($booking->getBookingfrom() <= $dateToday && $booking->getBookingtill() >= $dateToday) {
                        if ($booking->getOccupancies()) {
                            $occupancies = $booking->getOccupancies();
                            if ($occupancies) {
                                foreach ($occupancies as $occupancy) {
                                    $occunciesArray[] = $occupancy;
                                }
                                $occunciesArray[] = 'a';
                            }
                        }
                    }
                }
            }
            $roomArray[] =[
                'id' => $room->getId(),
                'name' => $room->getName(),
                'beds' => $room->getBeds(),
                'floor' => $room->getFloor(),
                'house' => $room->getHouse(),
                'occupancies' => count($occunciesArray),
            ];
        }
        return $this->json($roomArray);
    }




    /**
     * @Route("/", name="room_index", methods={"GET"})
     */
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $room->setTstamp(time());
            $room->setHidden(0);
            $room->setDeleted(0);
            $room->setCrdate(time());
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'roomForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET"})
     */
    public function show(Room $room): Response
    {
        $bookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findBy(['bookedroom' => $room->getId()]);

        return $this->render('room/show.html.twig', [
            'room' => $room,
            'booking' => $bookings
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_index', [
                'id' => $room->getId(),
            ]);
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'roomForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="room_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $room->setTstamp(time());
            $room->setDeleted(1);
//            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_index');
    }
}
