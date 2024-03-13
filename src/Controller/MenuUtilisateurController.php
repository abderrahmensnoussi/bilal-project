<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuUtilisateurController extends AbstractController
{
    #[Route('/menu/utilisateur', name: 'app_menu_utilisateur')]
    public function index(): Response
    {
        return $this->render('menu_utilisateur/index.html.twig', [
            'controller_name' => 'MenuUtilisateurController',
        ]);
    }
}
