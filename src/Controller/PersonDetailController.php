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

#[Route('/person/detail', name: 'detail_')]
class PersonDetailController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PersonDetailRepository $personDetailRepository): Response
    {
        return $this->render('person_detail/index.html.twig', [
            'person_details' => $personDetailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personDetail = new PersonDetail();
        $personDetailForm = $this->createForm(PersonDetailType::class, $personDetail);
        $personDetailForm->handleRequest($request);

        if ($personDetailForm->isSubmitted() && $personDetailForm->isValid()) {
            $entityManager->persist($personDetail);
            $entityManager->flush();

            return $this->redirectToRoute('detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('person_detail/new.html.twig', [
            'person_detail' => $personDetail,
            'personDetailForm' => $personDetailForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(PersonDetail $personDetail): Response
    {
        return $this->render('person_detail/show.html.twig', [
            'person_detail' => $personDetail,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonDetail $personDetail, EntityManagerInterface $entityManager): Response
    {
        $personDetailForm = $this->createForm(PersonDetailType::class, $personDetail);
        $personDetailForm->handleRequest($request);

        if ($personDetailForm->isSubmitted() && $personDetailForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('person_detail/edit.html.twig', [
            'person_detail' => $personDetail,
            'personDetailForm' => $personDetailForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, PersonDetail $personDetail, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personDetail->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($personDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_index', [], Response::HTTP_SEE_OTHER);
    }
}
