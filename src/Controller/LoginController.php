<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash('error', 'Votre email ou votre mot de passe est incorrecte');
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
        ]);


    }

    #[Route('/redirect', name: 'app_redirect', methods: ['GET'])]
    public function redirect_section()
    {
        if ($this->getUser())
            {
            $user = $this->getUser();
            switch ($user->getRoles()[0])
            {

                case "ROLE_MONITEUR":
                    $this->redirectToRoute("app_user");
                case "ROLE_ADMIN":
                    $this->redirectToRoute("app_user");
                case "ROLE_USER":
                    return $this->redirectToRoute("app_user");
            }
        }
            return $this->redirectToRoute("app_login");
    }

}
