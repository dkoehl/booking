<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/", name="payment_index", methods={"GET"})
     */
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requestReg = $request->request->get('payment');
        $booking = $request->request->get('payment')['booking'];
        $request->request->remove('payment')['booking'];
        
        if($booking){
            $payment = new Payment();
            $payment->setPayment($requestReg['payment']);
            $payment->setNumber($requestReg['number']);
            $payment->setSecuritynumber($requestReg['securitynumber']);
            
            $payment->setTstamp(time());
            $payment->setHidden(0);
            $payment->setDeleted(0);
            $payment->setCrdate(time());
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();
    
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $entityManager->getRepository(Booking::class)->find($booking);
            $booking->addPayment($payment);
            $payment->setBooking($booking);
            $entityManager->flush();
    
            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
            ]);
        }
        
        $payment = new Payment();
        $paymentForm = $this->createForm(PaymentType::class, $payment);
        return $this->render('payment/new.html.twig', [
            'payment' => $payment,
            'paymentForm' => $paymentForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_show", methods={"GET"})
     */
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Payment $payment): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_index');
        }

        return $this->render('payment/edit.html.twig', [
            'payment' => $payment,
            'paymentForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Payment $payment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $payment->setTstamp(time());
            $payment->setDeleted(1);
//            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_index');
    }
}
