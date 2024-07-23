<?php

namespace App\Controller;

use App\Entity\Description;
use App\Entity\LeaseParty;
use App\Entity\Property;
use App\Entity\Tax;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/property', name: 'property_')]
class PropertyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $property = new Property();
    // Creating new Description and Tax objects
    $description = new Description();
    $tax = new Tax();

    // Adding the Description and Tax to the Property
    $property->addDescription($description);
    $property->addTax($tax);

    // Persist the Property entity before creating the form
    $entityManager->persist($property);

    $propertyForm = $this->createForm(PropertyType::class, $property);
    $propertyForm->handleRequest($request);

    if ($propertyForm->isSubmitted() && $propertyForm->isValid()) {
        $tenant = $propertyForm->get('leaseParty')->getData();

        if ($entityManager->getRepository(LeaseParty::class)->isTenantOccupied($tenant)) {
            // The tenant belongs to a place, show error message
            $this->addFlash('error', 'Le locataire sélectionné est déjà occupé dans un autre bien.');
        } else {
            // The tenant doesn't belong to a place, submit form
            $entityManager->flush();
            $this->addFlash('success', 'Votre bien immobilier vient d\'être ajouté');
            return $this->redirectToRoute('property_show');
        }
    }

    return $this->render('property/new.html.twig', [
        'property' => $property,
        'propertyForm' => $propertyForm->createView()
    ]);
}


    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(PropertyRepository $propertyRepository): Response
    {
        // Récupération des propriétés par ordre croissant d'ID, et passage à la vue
        $properties = $propertyRepository->findBy([], ['id' => 'ASC']);
        return $this->render('property/show.html.twig', [
            'properties' => $properties,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
         // Vérification que l'utilisateur connecté est le propriétaire du bien
         if ($property->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $propertyForm = $this->createForm(PropertyType::class, $property);
        $propertyForm->handleRequest($request);

        if ($propertyForm->isSubmitted() && $propertyForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le bien immobilier a été modifié avec succès.');

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/edit.html.twig', [
            'property' => $property,
            'propertyForm' => $propertyForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le bien a été supprimé avec succès.');

        return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
    }
}
