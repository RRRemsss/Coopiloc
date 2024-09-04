<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Rental;
use App\Entity\RentalDocument;
use App\Entity\Tenant;
use App\Form\RentalDocumentType;
use App\Repository\RentalDocumentRepository;
use App\Service\PdfGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rental/document', name: 'rentalDocument_')]
class RentalDocumentController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RentalDocumentRepository $rentalDocumentRepository): Response
    {
        return $this->render('rental_document/index.html.twig', [
            'rental_documents' => $rentalDocumentRepository->findAll(),
        ]);
    }

    // #[Route('/{tenantId}/{propertyId}', name: 'generate', methods: ['GET', 'POST'])]
    // public function generateReceipt(int $tenantId,
    //                                 int $propertyId,
                                    
    //                                 EntityManagerInterface $entityManager,
    //                                 PdfGeneratorService $pdfGeneratorService): Response
    // {
    //     //Get entities Tenant, Property and User
    //     $tenant = $entityManager->getRepository(Tenant::class)->find($tenantId);
    //     $property = $entityManager->getRepository(Property::class)->find($propertyId);
        


    //     $user = $this->getUser(); // User = owner (TODO: make User = Tenant)

    //      // Assurez-vous que les entités existent
    //      if (!$tenant || !$property || !$user) {
    //         throw $this->createNotFoundException('Les informations demandées n\'existent pas ou il en manque. 
    //         Veuillez rensiegner les informations de la propriété, du/des locataires et de la location');
    //     }

    //     // Prepare datas for template Twig
    //     $data = [
    //         'tenant' => $tenant,
    //         'property' => $property,
    //         'user' => $user,
    //     ];

    //     // Generate PDF
    //     $pdf = $pdfGeneratorService->generatePdf('rental_document/rental_document_template.html.twig', $data);

    //         return new Response($pdf, 200, [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'inline; filename="quittance-de-loyer.pdf"',
    //     ]);
    // }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(RentalDocument $rentalDocument): Response
    {
        return $this->render('rental_document/show.html.twig', [
            'rental_document' => $rentalDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, RentalDocument $rentalDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RentalDocumentType::class, $rentalDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rentalDocument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rental_document/edit.html.twig', [
            'rental_document' => $rentalDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, RentalDocument $rentalDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rentalDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rentalDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rentalDocument_index', [], Response::HTTP_SEE_OTHER);
    }
}
