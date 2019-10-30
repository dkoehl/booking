<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Price;
use App\Form\PriceType;
use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/price")
 */
class PriceController extends AbstractController
{
    /**
     * @Route("/", name="price_index", methods={"GET"})
     */
    public function index(PriceRepository $priceRepository): Response
    {
        return $this->render('price/index.html.twig', [
            'prices' => $priceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="price_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requestReg = $request->request->get('price');
        $booking = $request->request->get('price')['booking'];
        $request->request->remove('price')['booking'];
    
        if ($booking) {
            $price = new Price();
            $price->setType($requestReg['type']);
            $price->setPrice($requestReg['price']);
            $price->setTax($requestReg['tax']);
            $price->setAmount($requestReg['amount']);
            $price->setTstamp(time());
            $price->setHidden(0);
            $price->setDeleted(0);
            $price->setCrdate(time());
//            dump($price);
//            die('a');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($price);
            $entityManager->flush();
    
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $entityManager->getRepository(Booking::class)->find($booking);
            $booking->addPrice($price);
            $entityManager->flush();
            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
            ]);
            
        }
        $price = new Price();
        $priceForm = $this->createForm(PriceType::class, $price);
        return $this->render('price/new.html.twig', [
            'price' => $price,
            'priceForm' => $priceForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="price_show", methods={"GET"})
     */
    public function show(Price $price): Response
    {
        return $this->render('price/show.html.twig', [
            'price' => $price,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="price_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Price $price): Response
    {
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('price_index');
        }

        return $this->render('price/edit.html.twig', [
            'price' => $price,
            'priceForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="price_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Price $price): Response
    {
        if ($this->isCsrfTokenValid('delete'.$price->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $price->setTstamp(time());
            $price->setDeleted(1);
//            $entityManager->remove($price);
            $entityManager->flush();
        }

        return $this->redirectToRoute('price_index');
    }
}
