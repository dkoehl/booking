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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

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
        $guests = $guestRepository->findAll();
        foreach ($guests as $guest) {
            if ($guest->getHidden() || $guest->getDeleted() || $guest->getId() == 1) {
                continue;
            }
            $guestArray[] =[
                'id' => $guest->getId(),
                'lastname' => $guest->getLastname(),
                'firstname' => $guest->getFirstname(),
                'birthday' => $guest->getBirthday(),
                'bookings' => count($guest->getBookings())
            ];
        }
        return $this->json($guestArray);
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
        $guest = new Guest();
        $guestForm = $this->createForm(GuestType::class, $guest);
        $guestForm->handleRequest($request);
        $guest->setTstamp(time());
        $guest->setHidden(0);
        $guest->setDeleted(0);
        
        // create new user
        if ($booking === null) {
            if ($guestForm->isSubmitted() && $guestForm->isValid()) {
                $guest->setCrdate(time());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($guest);
                $entityManager->flush();
                return $this->redirectToRoute('guest_index');
            }
            return $this->render('guest/new.html.twig', [
                'guest' => $guest,
                'guestForm' => $guestForm->createView(),
            ]);
        }
    
        // add user to booking
        if ($booking) {
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
            $guest->setCompanyname($requestReg['companyname']);
            $guest->setAddress($requestReg['address']);
            $guest->setTaxnumber($requestReg['taxnumber']);
            $guest->setSignatureauthorized($requestReg['signatureauthorized']);
            $guest->setPlaceofbirth($requestReg['placeofbirth']);
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guest);
            $entityManager->flush();
        
            if($booking != 'new'){
                $entityManager = $this->getDoctrine()->getManager();
                $booking = $entityManager->getRepository(Booking::class)->find($booking);
                $booking->setGuest($guest);
                $entityManager->flush();
                return $this->redirectToRoute('booking_show', [
                    'id' => $booking->getId(),
                ]);
            }
            return $this->redirectToRoute('guest_index');
        }
    }
    
    /**
     * @Route("/newbookingguest", name="newbookingguest", methods={"GET","POST"})
     */
    public function newbookingguest(Request $request): Response
    {
//        if (isset($request->request->get('guest')['bookings'])) {
//            $requestReg = $request->request->get('guest');
//            $bookingID = $request->request->get('guest')['bookings'];
//            $request->request->remove('guest')['bookings'];
//            if ($bookingID != 'new') {
//                $guest = new Guest();
//                $guest->setLastname($requestReg['lastname']);
//                $guest->setFirstname($requestReg['firstname']);
//                $guest->setBirthday(\DateTime::createFromFormat(
//                    'Y-m-d H:i:s',
//                    date(
//                        'Y-m-d H:i:s',
//                        strtotime($requestReg['birthday']
//                        )
//                    )
//                ));
//                $guest->setCountry($requestReg['country']);
//                $guest->setPhone($requestReg['phone']);
//                $guest->setEmail($requestReg['email']);
//                $guest->setPersonalid($requestReg['personalid']);
//                $guest->setType($requestReg['type']);
//                $guest->setCompanyname($requestReg['companyname']);
//                $guest->setAddress($requestReg['address']);
//                $guest->setTaxnumber($requestReg['taxnumber']);
//                $guest->setSignatureauthorized($requestReg['signatureauthorized']);
//                $guest->setPlaceofbirth($requestReg['placeofbirth']);
//
//                $guest->setTstamp(time());
//                $guest->setHidden(0);
//                $guest->setDeleted(0);
//                $guest->setCrdate(time());
//
//
//                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->persist($guest);
//                $entityManager->flush();
//
//                $entityManager = $this->getDoctrine()->getManager();
//                $booking = $entityManager->getRepository(Booking::class)->find($bookingID);
//                $booking->setGuest($guest);
//                $entityManager->flush();
//
//                return $this->redirectToRoute('booking_show', [
//                    'id' => $booking->getId(),
//                ]);
//            }
//        }
        
        
        // is create form
        $guest = new Guest();
        $guestForm = $this->createForm(GuestType::class, $guest);
        $guestForm->handleRequest($request);
        if ($guestForm->isSubmitted() && $guestForm->isValid()) {
            $guest->setTstamp(time());
            $guest->setHidden(0);
            $guest->setDeleted(0);
            $guest->setCrdate(time());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guest);
            $entityManager->flush();
            return $this->redirectToRoute('guest_index');
        }
        return $this->render('guest/_booking_new_guest_form.html.twig', [
            'guest' => $guest,
            'guestForm' => $guestForm->createView(),
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
        $guestForm = $this->createForm(GuestType::class, $guest);
        $guestForm->handleRequest($request);
    
        if ($guestForm->isSubmitted() && $guestForm->isValid()) {
            $guest->setTstamp(time());
            $this->getDoctrine()->getManager()->flush();
        
            return $this->redirectToRoute('guest_index');
        }

        return $this->render('guest/edit.html.twig', [
            'guest' => $guest,
            'guestForm' => $guestForm->createView(),
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
