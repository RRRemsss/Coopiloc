<?php

namespace App\Controller;

use App\Entity\Guarantor;
use App\Entity\IdentityDocument;
use App\Entity\IdentityLeaseParty;
use App\Entity\Tenant;
use App\Form\TenantType;
use App\Repository\TenantRepository;
use App\Service\UploadFilesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/tenant', name: 'tenant_')]
class TenantController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TenantRepository $tenantRepository): Response
    {
        return $this->render('tenant/index.html.twig', [
            'tenants' => $tenantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UploadFilesService $uploadFilesService): Response
    {
        $tenant = new Tenant();
        $tenantIdentityLeaseParty = new IdentityLeaseParty(); // Create a new instance of IdentityLEaseParty for Tenant
        $tenant->setIdentityLeaseParty($tenantIdentityLeaseParty); // Associate this instance to Tenant

        // Creating new Guarantor
        $guarantor = new Guarantor ();
        $guarantorIdentityLeaseParty = new IdentityLeaseParty(); // Create a new instance of IdentityLEaseParty for Guarantor
        $guarantor->setIdentityLeaseParty($guarantorIdentityLeaseParty); // Associate this instance to Guarantor
        $tenant -> addGuarantor($guarantor);
                
        $tenantForm = $this->createForm(TenantType::class, $tenant);
        $tenantForm->handleRequest($request);

        if ($tenantForm->isSubmitted() && $tenantForm->isValid()) {

            foreach ($tenant->getGuarantors() as $index => $guarantor) {
                $guarantor->setTenant($tenant); // Associat each guarantor to a tenant
                $entityManager->persist($guarantor); // Persist each guarantor

                // Handle guarantor's documents to upload
                $guarantorForm = $tenantForm->get('guarantors')->get($index);
                $documents = $guarantorForm->get('guarantorDocuments')->getData();
                if ($documents) {
                    foreach ($documents as $document) {
                        if ($document instanceof UploadedFile) {
                            try {
                                $guarantorDocument = $uploadFilesService->uploadGuarantorDocument($document);
                                $guarantor->addGuarantorDocument($guarantorDocument);
                            } catch (\Exception $e) {
                                $this->addFlash('error', $e->getMessage());
                                return $this->redirectToRoute('tenant_new');
                            }
                        }
                    }
                }
            }

            // Handle tenant's documents to upload
            $documents = $tenantForm->get('tenantDocuments')->getData();
            if ($documents) {
                foreach ($documents as $document) {
                    if ($document instanceof UploadedFile) {
                        try {
                            $tenantDocument = $uploadFilesService->uploadTenantDocument($document);
                            $tenant->addTenantDocument($tenantDocument);
                        } catch (\Exception $e) {
                            $this->addFlash('error', $e->getMessage());
                            return $this->redirectToRoute('tenant_new');
                        }
                    }
                }
            }

            $entityManager->persist($tenant);
            $entityManager->flush();


            return $this->redirectToRoute('tenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tenant/new.html.twig', [
            'tenant' => $tenant,
            'tenantForm' => $tenantForm->createView(),
        ]);

    }


    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Tenant $tenant): Response
    {
        return $this->render('tenant/show.html.twig', [
            'tenant' => $tenant,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Tenant $tenant, EntityManagerInterface $entityManager): Response
    {
        $tenantForm = $this->createForm(TenantType::class, $tenant);
        $tenantForm->handleRequest($request);

        if ($tenantForm->isSubmitted() && $tenantForm->isValid()) {

            foreach ($tenant->getGuarantors() as $guarantor) {
                $guarantor->setTenant($tenant); // Associer chaque garant au locataire
                $entityManager->persist($guarantor); // Persister chaque garant
            }
            $entityManager->flush();

            return $this->redirectToRoute('tenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tenant/edit.html.twig', [
            'tenant' => $tenant,
            'tenantForm' => $tenantForm ->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Tenant $tenant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tenant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tenant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tenant_index', [], Response::HTTP_SEE_OTHER);
    }
}
