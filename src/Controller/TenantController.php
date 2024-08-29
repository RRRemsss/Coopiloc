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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $tenant = new Tenant();
        // Creating new Guarantor
        $guarantor = new Guarantor ();
        $tenant -> addGuarantor($guarantor);
                
        $tenantForm = $this->createForm(TenantType::class, $tenant);
        $tenantForm->handleRequest($request);

        if ($tenantForm->isSubmitted() && $tenantForm->isValid()) {

            foreach ($tenant->getGuarantors() as $guarantor) {
                $guarantor->setTenant($tenant); // Associer chaque garant au locataire
                $entityManager->persist($guarantor); // Persister chaque garant
            }
           
            $documents = $tenantForm->get('identityDocuments')->getData();

            // Handle documents to upload
            if ($documents) {
                foreach ($documents as $document) {
                    if ($document instanceof UploadedFile) {

                        // Validating manually uploaded
                        $mimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                        if (!in_array($document->getMimeType(), $mimeTypes)) {
                            $this->addFlash('error', 'Type de fichier de document non valide.');
                            return $this->redirectToRoute('tenant_new');
                        }
                        if ($document->getSize() > 10 * 1024 * 1024) { // 10MB
                            $this->addFlash('error', 'Le document est trop volumineux.');
                            return $this->redirectToRoute('tenant_new');
                        }

                        $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                        $newFilename = $slugger->slug($originalFilename).'-'.uniqid().'.'.$document->guessExtension();
                        try {
                            $document->move(
                                $this->getParameter('documentsProperty_directory'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Erreur lors de l\'upload du document : ' . $e->getMessage());
                            return $this->redirectToRoute('tenant_new');
                        }

                        $identityDocument = new IdentityDocument();
                        $identityDocument->setFilePathIdentityDocument($newFilename); 
                        //TODO
                        // $tenant->setIdentityLeaseParty($identityLeaseParty);

                        $entityManager->persist($identityDocument);
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
