<?php

namespace App\Controller;

use App\Entity\PersonDetail;
use App\Entity\Property;
use App\Entity\Rental;
use App\Entity\Tenant;
use App\Form\RentalType;
use App\Repository\RentalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rental', name: 'rental_')]
class RentalController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RentalRepository $rentalRepository): Response
    {
        return $this->render('rental/index.html.twig', [
            'rentals' => $rentalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rental = new Rental();
        $userProperties = $entityManager->getRepository(Property::class)->findBy(['user' => $this->getUser()]);
    
        $tenantChoices = $entityManager->getRepository(Tenant::class)->findAll();
        $rentalForm = $this->createForm(RentalType::class, $rental, [
            'tenant_choices' => $tenantChoices,
        ]);
        
        $rentalForm->handleRequest($request);
    
        if ($rentalForm->isSubmitted() && $rentalForm->isValid()) {
            $entityManager->persist($rental);
            $entityManager->flush();
    
            return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('rental/new.html.twig', [
            'rental' => $rental,
            'userProperties' => $userProperties,
            'rentalForm' => $rentalForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Rental $rental): Response
    {
        return $this->render('rental/show.html.twig', [
            'rental' => $rental,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Rental $rental, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('success', 'La location a été supprimée avec succès.');

        return $this->render('rental/edit.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Rental $rental, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rental->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rental);
            $entityManager->flush();
        }
        $this->addFlash('success', 'La location a été supprimée avec succès.');

        return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
    }
}
