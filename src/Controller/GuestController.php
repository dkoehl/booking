<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Form\GuestType;
use App\Repository\GuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/guest")
 */
class GuestController extends AbstractController
{
    /**
     * @Route("/getguestbyajaxsearch/{input}", name="getguestbyajaxsearch")
     *
     */
    public function getGuestByAjaxSearch(Request $request, GuestRepository $guestRepository){
        $requestUri = explode('/', $request->getRequestUri());
        if(!empty($requestUri[3])){
            $input = $requestUri[3];
            $guest = $guestRepository->getGuestByAjaxSearch($input);

            return $this->json($guest);
        }
    }
    /**
     * @Route("/overview")
     */
    public function overview(GuestRepository $guestRepository): Response
    {
//        $guests = $guestRepository->findAll();
//        $encoders = array(new XmlEncoder(), new JsonEncoder());
//        $normalizers = array(new GetSetMethodNormalizer());
//        $serializer = new Serializer($normalizers, $encoders);
//
//        $response = new JsonResponse();
//        $jsonObject = $serializer->serialize($guests, 'json', [
//            'circular_reference_handler' => function ($object) {
//                return $object->getId();
//            }
//        ]);
//        $response->setData(json_decode($jsonObject));
//        $response->headers->set('Content-Type', 'application/json');
//        return $response;
    }





    /**
     * @Route("/", name="guest_index", methods={"GET"})
     */
    public function index(GuestRepository $guestRepository): Response
    {
        return $this->render('guest/index.html.twig', [
            'guests' => $guestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="guest_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requestReg = $request->request->get('guest');
        $booking = $request->request->get('guest')['bookings'];
        $request->request->remove('guest')['bookings'];
    
        if ($booking) {
            $guest = new Guest();
            $guest->setLastname($requestReg['lastname']);
            $guest->setFirstname($requestReg['firstname']);
            $guest->setBirthday(\DateTime::createFromFormat(
                'Y-m-d H:i:s',
                date(
                    'Y-m-d H:i:s',
                    strtotime($requestReg['birthday']
                    )
                )
            ));
            $guest->setCountry($requestReg['country']);
            $guest->setPhone($requestReg['phone']);
            $guest->setEmail($requestReg['email']);
            $guest->setPersonalid($requestReg['personalid']);
            $guest->setType($requestReg['type']);
            $guest->setTstamp(time());
            $guest->setHidden(0);
            $guest->setDeleted(0);
            $guest->setCrdate(time());
        
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guest);
            $entityManager->flush();
        
            $entityManager = $this->getDoctrine()->getManager();
            $booking = $entityManager->getRepository(Booking::class)->find($booking);
            $booking->setGuest($guest);
            $entityManager->flush();
    
            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
            ]);
        }

        return $this->render('guest/new.html.twig', [
            'guest' => $guest,
            'guestForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guest_show", methods={"GET"})
     */
    public function show(Guest $guest): Response
    {
        $bookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findBy(['guest' => $guest->getId()], ['bookingfrom' => 'ASC']);
        return $this->render('guest/show.html.twig', [
            'guest' => $guest,
            'bookings' => $bookings
        ]);
    }

    /**
     * @Route("/{id}/edit", name="guest_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Guest $guest): Response
    {
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guest->setTstamp(time());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guest_index', [
                'id' => $guest->getId(),
            ]);
        }

        return $this->render('guest/edit.html.twig', [
            'guest' => $guest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guest_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Guest $guest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guest_index');
    }
}
