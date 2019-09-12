<?php

namespace App\Controller;

use App\Entity\Damage;
use App\Form\DamageType;
use App\Repository\DamageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/damage")
 */
class DamageController extends AbstractController
{
    /**
     * @Route("/", name="damage_index", methods={"GET"})
     */
    public function index(DamageRepository $damageRepository): Response
    {
        return $this->render('damage/index.html.twig', [
            'damages' => $damageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="damage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $damage = new Damage();
        $form = $this->createForm(DamageType::class, $damage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($damage);
            $entityManager->flush();

            return $this->redirectToRoute('damage_index');
        }

        return $this->render('damage/new.html.twig', [
            'damage' => $damage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="damage_show", methods={"GET"})
     */
    public function show(Damage $damage): Response
    {
        return $this->render('damage/show.html.twig', [
            'damage' => $damage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="damage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Damage $damage): Response
    {
        $form = $this->createForm(DamageType::class, $damage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('damage_index');
        }

        return $this->render('damage/edit.html.twig', [
            'damage' => $damage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="damage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Damage $damage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$damage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($damage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('damage_index');
    }
}
