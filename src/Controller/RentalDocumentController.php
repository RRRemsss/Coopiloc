<?php

namespace App\Controller;

use App\Entity\RentalDocument;
use App\Form\RentalDocumentType;
use App\Repository\RentalDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rental/document', name: 'rentalDocument_')]
class RentalDocumentController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RentalDocumentRepository $rentalDocumentRepository): Response
    {
        return $this->render('rental_document/index.html.twig', [
            'rental_documents' => $rentalDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rentalDocument = new RentalDocument();
        $form = $this->createForm(RentalDocumentType::class, $rentalDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rentalDocument);
            $entityManager->flush();

            return $this->redirectToRoute('rentalDocument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rental_document/new.html.twig', [
            'rental_document' => $rentalDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(RentalDocument $rentalDocument): Response
    {
        return $this->render('rental_document/show.html.twig', [
            'rental_document' => $rentalDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, RentalDocument $rentalDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RentalDocumentType::class, $rentalDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rentalDocument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rental_document/edit.html.twig', [
            'rental_document' => $rentalDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, RentalDocument $rentalDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rentalDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rentalDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rentalDocument_index', [], Response::HTTP_SEE_OTHER);
    }
}
