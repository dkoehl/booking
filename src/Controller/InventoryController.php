<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Form\InventoryType;
use App\Repository\InventoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inventory")
 */
class InventoryController extends AbstractController
{
    /**
     * @Route("/", name="inventory_index", methods={"GET"})
     */
    public function index(InventoryRepository $inventoryRepository): Response
    {
        return $this->render('inventory/index.html.twig', [
            'inventories' => $inventoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="inventory_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $inventory = new Inventory();
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $inventory->setTstamp(time());
            $inventory->setHidden(0);
            $inventory->setDeleted(0);
            $inventory->setCrdate(time());
            $entityManager->persist($inventory);
            $entityManager->flush();

            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('inventory/new.html.twig', [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inventory_show", methods={"GET"})
     */
    public function show(Inventory $inventory): Response
    {
        return $this->render('inventory/show.html.twig', [
            'inventory' => $inventory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inventory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inventory $inventory): Response
    {
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('inventory/edit.html.twig', [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inventory_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inventory $inventory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $inventory->setTstamp(time());
            $inventory->setDeleted(1);
//            $entityManager->remove($inventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inventory_index');
    }
}
