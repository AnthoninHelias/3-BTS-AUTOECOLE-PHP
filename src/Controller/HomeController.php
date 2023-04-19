<?php

namespace App\Controller;

use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('home/profil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/profil/edit', name: 'app_profil_edit')]
    public function profilEdit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_profil');
        }
        return $this->render('home/editprofil.html.twig', [
            'profilEditForm' => $form->createView(),
        ]);
    }

    #[Route('/password/edit', name: 'app_password_edit')]
    public function passwordEdit(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            //Verification si les deux mdp sont identiques
            if($request->get('pwd') == $request->request->get('pwdCheck')){
                $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('pwd')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour');

                return $this->redirectToRoute('app_profil');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        return $this->render('home/editpassword.html.twig');
    }
}
