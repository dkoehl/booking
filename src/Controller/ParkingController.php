<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Parking;
use App\Form\ParkingType;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parking")
 */
class ParkingController extends AbstractController
{
    /**
     * @Route("/", name="parking_index", methods={"GET"})
     */
    public function index(ParkingRepository $parkingRepository): Response
    {
        return $this->render('parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="parking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requestReg = $request->request->get('parking');
        $booking = $request->request->get('parking')['booking'];
        $request->request->remove('parking');
    
        if ($booking) {
            $parking = new Parking();
            $parking->setCarplate($requestReg['carplate']);
            $parking->setStartdate(
                \DateTime::createFromFormat(
                    'Y-m-d H:i:s',
                    date('Y-m-d H:i:s', strtotime($requestReg['startdate'])
                
                    )
                ));
            $parking->setEnddate(
                \DateTime::createFromFormat(
                    'Y-m-d H:i:s',
                    date('Y-m-d H:i:s', strtotime($requestReg['enddate'])
                
                    )
                ));
            $parking->setPrice($requestReg['price']);
            $parking->setTstamp(time());
            $parking->setHidden(0);
            $parking->setDeleted(0);
            $parking->setCrdate(time());
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parking);
            $entityManager->flush();
        
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $entityManager->getRepository(Booking::class)->find($booking);
            $booking->addParking($parking);
            $parking->setBooking($booking);
            $entityManager->flush();
            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
            ]);
        }

//        dump($parking);
//        die('here');
        $parking = new Parking();
        $parkingForm = $this->createForm(ParkingType::class, $parking);
        return $this->render('parking/new.html.twig', [
            'parking' => $parking,
            'parkingForm' => $parkingForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parking_show", methods={"GET"})
     */
    public function show(Parking $parking): Response
    {
        return $this->render('parking/show.html.twig', [
            'parking' => $parking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="parking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Parking $parking): Response
    {
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('parking_index');
        }

        return $this->render('parking/edit.html.twig', [
            'parking' => $parking,
            'parkingForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Parking $parking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $parking->setTstamp(time());
            $parking->setDeleted(1);
//            $entityManager->remove($parking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('parking_index');
    }
}
