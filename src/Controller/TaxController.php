<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Tax;
use App\Form\TaxType;
use App\Repository\TaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tax', name: 'tax_')]
class TaxController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TaxRepository $taxRepository): Response
    {
        return $this->render('tax/index.html.twig', [
            'taxes' => $taxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Property $property): Response
    {
        $tax = new Tax();

        // Use property passed in setting
        $tax->setProperty($property);

        $taxForm = $this->createForm(TaxType::class, $tax);
        $taxForm->handleRequest($request);

        if ($taxForm->isSubmitted() && $taxForm->isValid()) {
            $entityManager->persist($tax);
            $entityManager->flush();

            return $this->redirectToRoute('tax_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tax/new.html.twig', [
            'tax' => $tax,
            'taxForm' => $taxForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Tax $tax): Response
    {
        return $this->render('tax/show.html.twig', [
            'tax' => $tax,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Tax $tax, EntityManagerInterface $entityManager): Response
    {
        $taxForm = $this->createForm(TaxType::class, $tax);
        $taxForm->handleRequest($request);

        if ($taxForm->isSubmitted() && $taxForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tax_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tax/edit.html.twig', [
            'tax' => $tax,
            'form' => $taxForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Tax $tax, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tax->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tax);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_index', [], Response::HTTP_SEE_OTHER);
    }
}
