<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Rental;
use App\Entity\RentalDocument;
use App\Entity\Tenant;
use App\Form\RentalDocumentType;
use App\Repository\RentalDocumentRepository;
use App\Service\DateService;
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

    #[Route('/{id}', name: 'rental_document')]
    public function generateRentalDocument(int $id, EntityManagerInterface $entityManager, PdfGeneratorService $pdfGeneratorService, DateService $dateService): Response
    {       
        // Get rental form its ID
        $rental = $entityManager->getRepository(Rental::class)->find($id);

        if (!$rental) {
            throw $this->createNotFoundException('Rental not found.');
        }

        // Get tenants linked to this rental
        $tenants = $rental->getTenants();

        // Get the property linked
        $property = $rental->getProperty();

        // Get the owner (from user) of the property
        $user = $property->getUser();

        // Get the currentDate to put date on documents
        $currentDate = new \DateTime();

        // Call the service to get the first working day of next month in the document
        $firstWorkingDayNextMonth = $dateService->getFirstWorkingDayOfNextMonth($currentDate);

        // To generate a pdf
        $pdfContent = $pdfGeneratorService->generatePdf('rental_document/receipt.html.twig', [
            'user' => $user,
            'tenants' => $tenants,
            'property' => $property,
            'rental' => $rental,
            'currentDate' => $currentDate,
            'firstWorkingDayNextMonth' => $firstWorkingDayNextMonth,
        ]);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="rental_document.pdf"',
        ]);
    }

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
