<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Damage;
use App\Entity\Deposite;
use App\Form\DepositeType;
use App\Repository\DepositeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/deposite")
 */
class DepositeController extends AbstractController
{
    /**
     * @Route("/", name="deposite_index", methods={"GET"})
     */
    public function index(DepositeRepository $depositeRepository): Response
    {
        return $this->render('deposite/index.html.twig', [
            'deposites' => $depositeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="deposite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requestReg = $request->request->get('deposite');
        $booking = $request->request->get('deposite')['booking'];
        $request->request->remove('deposite');

        if ($booking) {
            $deposite = new Deposite();
            $deposite->setAmount($requestReg['amount']);
            $deposite->setTstamp(time());
            $deposite->setHidden(0);
            $deposite->setDeleted(0);
            $deposite->setCrdate(time());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($deposite);
            $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $booking = $entityManager->getRepository(Booking::class)->find($booking);
            $booking->addDeposite($deposite);
            $deposite->setBooking($booking);
            $entityManager->flush();
            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
            ]);
        }

        $deposite = new Deposite();
        $form = $this->createForm(DepositeType::class, $deposite);
        $form->handleRequest($request);
        return $this->render('deposite/new.html.twig', [
            'deposite' => $deposite,
            'depositeForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="deposite_show", methods={"GET"})
     */
    public function show(Deposite $deposite): Response
    {
        return $this->render('deposite/show.html.twig', [
            'deposite' => $deposite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="deposite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Deposite $deposite): Response
    {
        $form = $this->createForm(DepositeType::class, $deposite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('deposite_index');
        }

        return $this->render('deposite/edit.html.twig', [
            'deposite' => $deposite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="deposite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Deposite $deposite): Response
    {
        if ($this->isCsrfTokenValid('delete' . $deposite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($deposite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('deposite_index');
    }
}
