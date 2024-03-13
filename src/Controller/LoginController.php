<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\LoginFormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // Obtenez le message d'erreur de l'authentification, s'il existe
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupérez le nom d'utilisateur saisi précédemment par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Créez une instance de votre formulaire de connexion
        $user = new Utilisateur();
        $form = $this->createForm(LoginFormulaireType::class, $user);

        // Gérez la soumission du formulaire
        $form->handleRequest($request);

        // Traitez les données soumises si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Vous pouvez ici ajouter votre logique d'authentification
            // Par exemple, vous pouvez vérifier les informations d'identification
            // et rediriger l'utilisateur vers une page spécifique s'il est authentifié avec succès.
        }

        // Afficher le formulaire dans votre vue
        return $this->render('login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
