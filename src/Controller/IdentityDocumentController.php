<?php

namespace App\Controller;

use App\Entity\IdentityDocument;
use App\Form\IdentityDocumentType;
use App\Repository\IdentityDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/identity/document')]
class IdentityDocumentController extends AbstractController
{
    #[Route('/', name: 'app_identity_document_index', methods: ['GET'])]
    public function index(IdentityDocumentRepository $identityDocumentRepository): Response
    {
        return $this->render('identity_document/index.html.twig', [
            'identity_documents' => $identityDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_identity_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $identityDocument = new IdentityDocument();
        $form = $this->createForm(IdentityDocumentType::class, $identityDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($identityDocument);
            $entityManager->flush();

            return $this->redirectToRoute('app_identity_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('identity_document/new.html.twig', [
            'identity_document' => $identityDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_identity_document_show', methods: ['GET'])]
    public function show(IdentityDocument $identityDocument): Response
    {
        return $this->render('identity_document/show.html.twig', [
            'identity_document' => $identityDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_identity_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IdentityDocument $identityDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IdentityDocumentType::class, $identityDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_identity_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('identity_document/edit.html.twig', [
            'identity_document' => $identityDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_identity_document_delete', methods: ['POST'])]
    public function delete(Request $request, IdentityDocument $identityDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$identityDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($identityDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_identity_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
