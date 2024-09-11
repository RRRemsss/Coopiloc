<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Rental;
use App\Entity\RentalDocument;
use App\Entity\Tenant;
use App\Form\RentalDocumentType;
use App\Form\RentalFilterType;
use App\Repository\RentalDocumentRepository;
use App\Service\CivilityService;
use App\Service\DateService;
use App\Service\PdfGeneratorService;
use App\Service\RecipientLetterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rental/document', name: 'rentalDocument_')]
class RentalDocumentController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, RentalDocumentRepository $rentalDocumentRepository): Response
    {
        // Formulaire de filtre
        $filterForm = $this->createForm(RentalFilterType::class);
        $filterForm->handleRequest($request);

        // Get filtered rental documents
        $filters = $filterForm->getData();
        $rentalDocuments = $rentalDocumentRepository->findFilteredRentals($filters);

        // Formulaires pour chaque rental document
        $forms = [];
        foreach ($rentalDocuments as $rentalDocument) {
            $rentalDocumentForm = $this->createForm(RentalDocumentType::class, $rentalDocument);
            $rentalDocumentForm->handleRequest($request);

            // Si le formulaire est soumis et valide, enregistrer les changements
            if ($rentalDocumentForm->isSubmitted() && $rentalDocumentForm->isValid()) {
                $entityManager->flush();
                return $this->redirectToRoute('rentalDocument_index'); // Éviter la resoumission
            }

            // Ajouter le formulaire dans un tableau avec l'ID comme clé
            $forms[$rentalDocument->getId()] = $rentalDocumentForm->createView();
        }

        return $this->render('rental_document/index.html.twig', [
            'rentalDocuments' => $rentalDocuments,
            'filterForm' => $filterForm->createView(),
            'forms' => $forms,
        ]);
    }

    #[Route('/{id}', name: 'rental_document')]
    public function generateRentalDocument(int $id, 
                                            EntityManagerInterface $entityManager, 
                                            PdfGeneratorService $pdfGeneratorService, 
                                            DateService $dateService, 
                                            CivilityService $civilityService,
                                            RecipientLetterService $recipientLetterService ): Response
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

        // Get civilityService to start the letter with the right greeting
        $greeting = $civilityService->determineCivility($tenants);

        // Get the tenant's names for the recipient of the letter
        $tenantNames = $recipientLetterService->getTenantsAddress($rental);

        // Generate pdf
        $pdfContent = $pdfGeneratorService->generatePdf('rental_document/receipt.html.twig', [
            'user' => $user,
            'tenants' => $tenants,
            'property' => $property,
            'rental' => $rental,
            'currentDate' => $currentDate,
            'firstWorkingDayNextMonth' => $firstWorkingDayNextMonth,
            'greeting' => $greeting,
            'tenantNames'=> $tenantNames,
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
