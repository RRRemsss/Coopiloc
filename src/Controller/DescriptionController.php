<?php

namespace App\Controller;

use App\Entity\Description;
use App\Entity\Property;
use App\Form\DescriptionType;
use App\Repository\DescriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/description', name: 'description_')]
class DescriptionController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(DescriptionRepository $descriptionRepository): Response
    {
        return $this->render('description/index.html.twig', [
            'descriptions' => $descriptionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Property $property): Response
    {
        $description = new Description();

        // Utiliser la propriété passée en paramètre
        $description->setProperty($property);

        $descriptionForm = $this->createForm(DescriptionType::class, $description);
        $descriptionForm->handleRequest($request);

        if ($descriptionForm->isSubmitted() && $descriptionForm->isValid()) {
            $entityManager->persist($description);
            $entityManager->flush();

            return $this->redirectToRoute('description_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('description/new.html.twig', [
            'description' => $description,
            'descriptionForm' => $descriptionForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Description $description): Response
    {
        return $this->render('description/show.html.twig', [
            'description' => $description,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Description $description, EntityManagerInterface $entityManager): Response
    {
        $descriptionForm = $this->createForm(DescriptionType::class, $description);
        $descriptionForm->handleRequest($request);

        if ($descriptionForm->isSubmitted() && $descriptionForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La description du bien a été modifiée avec succès.');

            return $this->redirectToRoute('description_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('description/edit.html.twig', [
            'description' => $description,
            'descriptionForm' => $descriptionForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Description $description, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$description->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($description);
            $entityManager->flush();
        }

        return $this->redirectToRoute('description_index', [], Response::HTTP_SEE_OTHER);
    }
}
