<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Occupancy;
use App\Form\OccupancyType;
use App\Repository\OccupancyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/occupancy")
 */
class OccupancyController extends AbstractController
{
    /**
     * @Route("/", name="occupancy_index", methods={"GET"})
     */
    public function index(OccupancyRepository $occupancyRepository): Response
    {
        return $this->render('occupancy/index.html.twig', [
            'occupancies' => $occupancyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="occupancy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requestReg = $request->request->get('occupancy');
        $booking = $request->request->get('occupancy')['booking'];
        $request->request->remove('occupancy');
        
        $occupancy = new Occupancy();
        
//        dump($requestReg);
//        die('her');
        
       
        
        if($booking){
            $occupancy->setName($requestReg['name']);
            $occupancy->setBirthday($requestReg['birthday']);
    
            $occupancy->setTstamp(time());
            $occupancy->setHidden(0);
            $occupancy->setDeleted(0);
            $occupancy->setCrdate(time());
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($occupancy);
            $entityManager->flush();
    
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $entityManager->getRepository(Booking::class)->find($booking);
            $booking->addOccupancy($occupancy);
            $occupancy->setBooking($booking);
            $entityManager->flush();
            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
            ]);
        }
        
        $form = $this->createForm(OccupancyType::class, $occupancy);
        $form->handleRequest($request);
        return $this->render('occupancy/new.html.twig', [
            'occupancy' => $occupancy,
            'occupancyForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="occupancy_show", methods={"GET"})
     */
    public function show(Occupancy $occupancy): Response
    {
        return $this->render('occupancy/show.html.twig', [
            'occupancy' => $occupancy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="occupancy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Occupancy $occupancy): Response
    {
        $form = $this->createForm(OccupancyType::class, $occupancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('occupancy_index');
        }

        return $this->render('occupancy/edit.html.twig', [
            'occupancy' => $occupancy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="occupancy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Occupancy $occupancy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$occupancy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($occupancy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('occupancy_index');
    }
}
