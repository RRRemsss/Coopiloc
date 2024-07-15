<?php

namespace App\Controller;

use App\Entity\PropertyDocument;
use App\Form\PropertyDocumentType;
use App\Repository\PropertyDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/property/document')]
class PropertyDocumentController extends AbstractController
{
    #[Route('/', name: 'app_property_document_index', methods: ['GET'])]
    public function index(PropertyDocumentRepository $propertyDocumentRepository): Response
    {
        return $this->render('property_document/index.html.twig', [
            'property_documents' => $propertyDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_property_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $propertyDocument = new PropertyDocument();
        $form = $this->createForm(PropertyDocumentType::class, $propertyDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($propertyDocument);
            $entityManager->flush();

            return $this->redirectToRoute('app_property_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property_document/new.html.twig', [
            'property_document' => $propertyDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_document_show', methods: ['GET'])]
    public function show(PropertyDocument $propertyDocument): Response
    {
        return $this->render('property_document/show.html.twig', [
            'property_document' => $propertyDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_property_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PropertyDocument $propertyDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropertyDocumentType::class, $propertyDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_property_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property_document/edit.html.twig', [
            'property_document' => $propertyDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_document_delete', methods: ['POST'])]
    public function delete(Request $request, PropertyDocument $propertyDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propertyDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($propertyDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_property_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
