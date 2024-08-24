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
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            $images = $propertyForm->get('propertyImages')->getData();
            $documents = $propertyForm->get('propertyDocuments')->getData();

            // Handle images to upload
            if ($images) {
                foreach ($images as $image) {
                    if ($image instanceof UploadedFile) {

                        // Validating manually uploaded
                        $mimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($image->getMimeType(), $mimeTypes)) {
                            $this->addFlash('error', 'Type de fichier d\'image non valide.');
                            return $this->redirectToRoute('property_new');
                        }
                        if ($image->getSize() > 5 * 1024 * 1024) { // 5MB
                            $this->addFlash('error', 'L\'image est trop volumineuse.');
                            return $this->redirectToRoute('property_new');
                        }

                        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $newFilename = $slugger->slug($originalFilename).'-'.uniqid().'.'.$image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('images_directory'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Erreur lors de l\'upload de l\'image : ' . $e->getMessage());
                            return $this->redirectToRoute('property_new');
                        }
                        
                        $propertyImage = new PropertyImage();
                        $propertyImage->setFilePathPropertyImage($newFilename);
                        $property->addPropertyImage($propertyImage);
                        $propertyImage->setCreatedAt(new \DateTime());
                        $propertyImage->setUpdatedAt(new \DateTime());
                    }
                }
            }

            // Handle documents to upload
            if ($documents) {
                foreach ($documents as $document) {
                    if ($document instanceof UploadedFile) {

                        // Validating manually uploaded
                        $mimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                        if (!in_array($document->getMimeType(), $mimeTypes)) {
                            $this->addFlash('error', 'Type de fichier de document non valide.');
                            return $this->redirectToRoute('property_new');
                        }
                        if ($document->getSize() > 10 * 1024 * 1024) { // 10MB
                            $this->addFlash('error', 'Le document est trop volumineux.');
                            return $this->redirectToRoute('property_new');
                        }

                        $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                        $newFilename = $slugger->slug($originalFilename).'-'.uniqid().'.'.$document->guessExtension();
                        try {
                            $document->move(
                                $this->getParameter('documents_directory'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Erreur lors de l\'upload du document : ' . $e->getMessage());
                            return $this->redirectToRoute('property_new');
                        }

                        $propertyDocument = new PropertyDocument();
                        $propertyDocument->setfilePathPropertyDocument($newFilename); 
                        $property->addPropertyDocument($propertyDocument);
                        $propertyDocument->setCreatedAt(new \DateTime());
                        $propertyDocument->setUpdatedAt(new \DateTime());
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
