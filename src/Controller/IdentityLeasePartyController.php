<?php

namespace App\Controller;

use App\Entity\IdentityLeaseParty;
use App\Form\IdentityLeasePartyType;
use App\Repository\IdentityLeasePartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/identityLeaseParty',name: 'identityLeaseParty_')]
class IdentityLeasePartyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(IdentityLeasePartyRepository $identityLeasePartyRepository): Response
    {
        return $this->render('Identity_leaseParty/index.html.twig', [
            'identity_documents' => $identityLeasePartyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $identityLeaseParty = new IdentityLeaseParty();
        $form = $this->createForm(IdentityLeasePartyType::class, $identityLeaseParty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($identityLeaseParty);
            $entityManager->flush();

            return $this->redirectToRoute('identityLeaseParty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Identity_leaseParty/new.html.twig', [
            'Identity_leaseParty' => $identityLeaseParty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(IdentityLeaseParty $identityLeaseParty): Response
    {
        return $this->render('Identity_leaseParty/show.html.twig', [
            'Identity_leaseParty' => $identityLeaseParty,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'],  methods: ['GET', 'POST'])]
    public function edit(Request $request, IdentityLeaseParty $identityLeaseParty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IdentityLeasePartyType::class, $identityLeaseParty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('identityLeaseParty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Identity_leaseParty/edit.html.twig', [
            'Identity_leaseParty' => $identityLeaseParty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'],  methods: ['POST'])]
    public function delete(Request $request, IdentityLeaseParty $identityLeaseParty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$identityLeaseParty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($identityLeaseParty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('identityLeaseParty_index', [], Response::HTTP_SEE_OTHER);
    }
}
