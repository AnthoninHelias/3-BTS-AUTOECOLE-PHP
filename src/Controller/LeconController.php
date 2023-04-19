<?php

namespace App\Controller;

use App\Entity\Lecon;
use App\Entity\User;
use App\Form\LeconType;
use App\Repository\LeconRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/lecon')]
class LeconController extends AbstractController
{

    #[Route('/', name: 'app_lecon_index', methods: ['GET'])]
    public function index(LeconRepository $leconRepository): Response
    {
        $user = $this->getUser();
        if(!empty($user)){
            $userId = $user->getId();
        }
        $leconUser= $leconRepository->leconOfUser($userId);

        return $this->render('lecon/index.html.twig', [
            'lecons' => $leconUser,

        ]);
    }

    #[Route('/new', name: 'app_lecon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LeconRepository $leconRepository): Response
    {
        $lecon = new Lecon();
        $form = $this->createForm(LeconType::class, $lecon);
        $lecon->addRelation($this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leconRepository->save($lecon, true);

            return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lecon/new.html.twig', [
            'lecon' => $lecon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecon_show', methods: ['GET'])]
    public function show(Lecon $lecon): Response
    {
        return $this->render('lecon/show.html.twig', [
            'lecon' => $lecon,
        ]);
    }

    #[Route('/{id}/calendar', name: 'app_lecon_calendar')]
    public function calendar(LeconRepository $calendar): Response
    {
        $events = $calendar->findAll();
        $newLecon = [];
        foreach($events as $event){
            $newLecon[] = [
                'id' => $event->getId(),
                'date' => $event->getDate(),
                'heure' => $event->getHeure(),
                'reglee' => $event->getReglee(),
                'immatriculation' => $event->getImmatriculation()

            ];
        }

        $data = json_encode($newLecon);
        return $this->render('lecon/calendar.html.twig', compact('data'));
    }

    #[Route('/{id}/edit', name: 'app_lecon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lecon $lecon, LeconRepository $leconRepository): Response
    {
        $form = $this->createForm(LeconType::class, $lecon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leconRepository->save($lecon, true);

            return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lecon/edit.html.twig', [
            'lecon' => $lecon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecon_delete', methods: ['POST'])]
    public function delete(Request $request, Lecon $lecon, LeconRepository $leconRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lecon->getId(), $request->request->get('_token'))) {
            $leconRepository->remove($lecon, true);
        }

        return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
    }
}
