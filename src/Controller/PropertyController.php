<?php

namespace App\Controller;

use App\Entity\Description;
use App\Entity\Property;
use App\Entity\PropertyDocument;
use App\Entity\PropertyImage;
use App\Entity\Tax;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
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

            // // Gestion des fichiers d'images
            // $imageFiles = $propertyForm->get('propertyImages')->getData();
            // foreach ($imageFiles as $imageFile) {
            //     if ($imageFile) {
            //         $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            //         $safeFilename = $slugger->slug($originalFilename);
            //         $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            //         try {
            //             $imageFile->move(
            //                 $this->getParameter('property_images_directory'),
            //                 $newFilename
            //             );
            //         } catch (FileException $e) {
            //             $this->addFlash('error', 'Erreur lors de l\'upload du fichier : ' . $e->getMessage());
            //             return $this->redirectToRoute('property_new');
            //         }

            //         // Créer et persister l'entité PropertyImage
            //         $propertyImage = new PropertyImage();
            //         $propertyImage->setFilePathPropertyImage($newFilename);
            //         $propertyImage->setProperty($property); // Lier à l'entité Property
            //         $entityManager->persist($propertyImage);
            //     }
            // }

            // // Gestion des fichiers de documents
            // $documentFiles = $propertyForm->get('propertyDocuments')->getData();
            // foreach ($documentFiles as $documentFile) {
            //     if ($documentFile) {
            //         $originalFilename = pathinfo($documentFile->getClientOriginalName(), PATHINFO_FILENAME);
            //         $safeFilename = $slugger->slug($originalFilename);
            //         $newFilename = $safeFilename . '-' . uniqid() . '.' . $documentFile->guessExtension();

            //         try {
            //             $documentFile->move(
            //                 $this->getParameter('property_documents_directory'),
            //                 $newFilename
            //             );
            //         } catch (FileException $e) {
            //             $this->addFlash('error', 'Erreur lors de l\'upload du document : ' . $e->getMessage());
            //             return $this->redirectToRoute('property_new');
            //         }

            //         // Créer et persister l'entité PropertyDocument
            //         $propertyDocument = new PropertyDocument();
            //         $propertyDocument->setFilePathPropertyDocument($newFilename);
            //         $propertyDocument->setProperty($property); // Lier à l'entité Property
            //         $entityManager->persist($propertyDocument);
            //     }
            // }

            // Persister la propriété avec toutes les entités liées
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
