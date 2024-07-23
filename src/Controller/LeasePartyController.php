<?php

namespace App\Controller;

use App\Entity\LeaseParty;
use App\Form\LeasePartyType;
use App\Repository\LeasePartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lease/party', name: 'leaseParty_')]
class LeasePartyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(LeasePartyRepository $leasePartyRepository): Response
    {
        return $this->render('lease_party/index.html.twig', [
            'lease_parties' => $leasePartyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $leaseParty = new LeaseParty();

        $leasePartyForm = $this->createForm(LeasePartyType::class, $leaseParty);
        $leasePartyForm->handleRequest($request);

        if ($leasePartyForm->isSubmitted() && $leasePartyForm->isValid()) {
            $entityManager->persist($leaseParty);
            $entityManager->flush();

            return $this->redirectToRoute('leaseParty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lease_party/new.html.twig', [
            'lease_party' => $leaseParty,
            'leasePartyForm' => $leasePartyForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(LeaseParty $leaseParty): Response
    {
        return $this->render('lease_party/show.html.twig', [
            'lease_party' => $leaseParty,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, LeaseParty $leaseParty, EntityManagerInterface $entityManager): Response
    {
        $leasePartyForm = $this->createForm(LeasePartyType::class, $leaseParty);
        $leasePartyForm->handleRequest($request);

        if ($leasePartyForm->isSubmitted() && $leasePartyForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le/la partie a été modifié avec succès.');

            return $this->redirectToRoute('leaseParty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lease_party/edit.html.twig', [
            'lease_party' => $leaseParty,
            'leasePartyForm' => $leasePartyForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, LeaseParty $leaseParty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leaseParty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($leaseParty);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le/la partie du contrat a été supprimé avec succès.');

        return $this->redirectToRoute('leaseParty_index', [], Response::HTTP_SEE_OTHER);
    }
}
