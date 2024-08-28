<?php

namespace App\Controller;

use App\Entity\Description;
use App\Entity\Property;
use App\Entity\Tax;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Service\UploadFilesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function new(Request $request, EntityManagerInterface $entityManager, UploadFilesService $uploadFilesService): Response
    {
        $property = new Property();

        // Creating new Description and Tax objects
        $description = new Description();
        $tax = new Tax();
        $property->addDescription($description);
        $property->addTax($tax);

        // Creating the form
        $propertyForm = $this->createForm(PropertyType::class, $property);
        $propertyForm->handleRequest($request);

        if ($propertyForm->isSubmitted() && $propertyForm->isValid()) {
            $images = $propertyForm->get('propertyImages')->getData();
            $documents = $propertyForm->get('propertyDocuments')->getData();

            // Handle images to upload
            if ($images) {
                foreach ($images as $image) {
                    if ($image instanceof UploadedFile) {
                        try {
                            $propertyImage = $uploadFilesService->uploadImageProperty($image);
                            $property->addPropertyImage($propertyImage);
                        } catch (\Exception $e) {
                            $this->addFlash('error', $e->getMessage());
                            return $this->redirectToRoute('property_new');
                        }
                    }
                }
            }

            // Handle documents to upload
            if ($documents) {
                foreach ($documents as $document) {
                    if ($document instanceof UploadedFile) {
                        try {
                            $propertyDocument = $uploadFilesService->uploadDocumentProperty($document);
                            $property->addPropertyDocument($propertyDocument);
                        } catch (\Exception $e) {
                            $this->addFlash('error', $e->getMessage());
                            return $this->redirectToRoute('property_new');
                        }
                    }
                }
            }

            $entityManager->persist($property);
            $entityManager->flush();

            $this->addFlash('success', 'Votre bien immobilier a été ajouté avec succès');

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/new.html.twig', [
            'property' => $property,
            'propertyForm' => $propertyForm->createView()
        ]);
    }


    // #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    // public function show(Property $property): Response
    // {
            
    //     return $this->render('property/show.html.twig', [
    //         'property' => $property,
    //     ]);
    // }

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
