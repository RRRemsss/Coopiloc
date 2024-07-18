<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home', methods: ['GET'])]
    public function index(): Response
    {
        // Get user connected
        $user = $this->getUser();

        return $this->render('main/home.html.twig', [
            'user' => $user,
        ]);
    }
}
