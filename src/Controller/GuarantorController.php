<?php

namespace App\Controller;

use App\Entity\Guarantor;
use App\Form\GuarantorType;
use App\Repository\GuarantorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/guarantor', name: 'guarantor_')]
class GuarantorController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(GuarantorRepository $guarantorRepository): Response
    {
        return $this->render('guarantor/index.html.twig', [
            'guarantors' => $guarantorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $guarantor = new Guarantor();
        $form = $this->createForm(GuarantorType::class, $guarantor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($guarantor);
            $entityManager->flush();

            return $this->redirectToRoute('guarantor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guarantor/new.html.twig', [
            'guarantor' => $guarantor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'guarantor_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Guarantor $guarantor): Response
    {
        return $this->render('guarantor/show.html.twig', [
            'guarantor' => $guarantor,
        ]);
    }

    #[Route('/{id}/edit', name: 'guarantor_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Guarantor $guarantor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuarantorType::class, $guarantor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('guarantor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guarantor/edit.html.twig', [
            'guarantor' => $guarantor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Guarantor $guarantor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guarantor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($guarantor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guarantor_index', [], Response::HTTP_SEE_OTHER);
    }
}
