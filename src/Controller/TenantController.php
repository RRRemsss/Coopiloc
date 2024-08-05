<?php

namespace App\Controller;

use App\Entity\Guarantor;
use App\Entity\Tenant;
use App\Form\TenantType;
use App\Repository\TenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tenant = new Tenant();

        // Creating new Guarantor
        $guarantor = new Guarantor ();
        $tenant -> addGuarantor($guarantor);

        $entityManager->persist($tenant);

                
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
