<?php

namespace App\Controller;

use App\Entity\PersonDetail;
use App\Form\PersonDetailType;
use App\Repository\PersonDetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person/detail')]
class PersonDetailController extends AbstractController
{
    #[Route('/', name: 'app_person_detail_index', methods: ['GET'])]
    public function index(PersonDetailRepository $personDetailRepository): Response
    {
        return $this->render('person_detail/index.html.twig', [
            'person_details' => $personDetailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_person_detail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personDetail = new PersonDetail();
        $form = $this->createForm(PersonDetailType::class, $personDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personDetail);
            $entityManager->flush();

            return $this->redirectToRoute('app_person_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('person_detail/new.html.twig', [
            'person_detail' => $personDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_person_detail_show', methods: ['GET'])]
    public function show(PersonDetail $personDetail): Response
    {
        return $this->render('person_detail/show.html.twig', [
            'person_detail' => $personDetail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_person_detail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonDetail $personDetail, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonDetailType::class, $personDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_person_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('person_detail/edit.html.twig', [
            'person_detail' => $personDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_person_detail_delete', methods: ['POST'])]
    public function delete(Request $request, PersonDetail $personDetail, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personDetail->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($personDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_person_detail_index', [], Response::HTTP_SEE_OTHER);
    }
}
