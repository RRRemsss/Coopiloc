<?php

namespace App\Controller;

use App\Entity\LandRegistry;
use App\Form\LandRegistryType;
use App\Repository\LandRegistryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/land/registry', name: 'landRegistry_')]
class LandRegistryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(LandRegistryRepository $landRegistryRepository): Response
    {
        return $this->render('land_registry/index.html.twig', [
            'land_registries' => $landRegistryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $landRegistry = new LandRegistry();
        $form = $this->createForm(LandRegistryType::class, $landRegistry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($landRegistry);
            $entityManager->flush();

            return $this->redirectToRoute('landRegistry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('land_registry/new.html.twig', [
            'land_registry' => $landRegistry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(LandRegistry $landRegistry): Response
    {
        return $this->render('land_registry/show.html.twig', [
            'land_registry' => $landRegistry,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, LandRegistry $landRegistry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LandRegistryType::class, $landRegistry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('landRegistry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('land_registry/edit.html.twig', [
            'land_registry' => $landRegistry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, LandRegistry $landRegistry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$landRegistry->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($landRegistry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('landRegistry_index', [], Response::HTTP_SEE_OTHER);
    }
}
