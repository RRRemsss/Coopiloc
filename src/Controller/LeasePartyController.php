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

#[Route('/lease/party')]
class LeasePartyController extends AbstractController
{
    #[Route('/', name: 'app_lease_party_index', methods: ['GET'])]
    public function index(LeasePartyRepository $leasePartyRepository): Response
    {
        return $this->render('lease_party/index.html.twig', [
            'lease_parties' => $leasePartyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lease_party_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $leaseParty = new LeaseParty();
        $form = $this->createForm(LeasePartyType::class, $leaseParty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($leaseParty);
            $entityManager->flush();

            return $this->redirectToRoute('app_lease_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lease_party/new.html.twig', [
            'lease_party' => $leaseParty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lease_party_show', methods: ['GET'])]
    public function show(LeaseParty $leaseParty): Response
    {
        return $this->render('lease_party/show.html.twig', [
            'lease_party' => $leaseParty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lease_party_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LeaseParty $leaseParty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LeasePartyType::class, $leaseParty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lease_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lease_party/edit.html.twig', [
            'lease_party' => $leaseParty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lease_party_delete', methods: ['POST'])]
    public function delete(Request $request, LeaseParty $leaseParty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leaseParty->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($leaseParty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lease_party_index', [], Response::HTTP_SEE_OTHER);
    }
}
