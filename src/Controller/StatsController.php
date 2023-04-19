<?php

namespace App\Controller;

use App\Repository\LeconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stats')]
class StatsController  extends AbstractController
{
    #[Route('/', name: 'app_stats', methods: ['GET'])]
    public function index(LeconRepository $leconRepository): Response
    {
        $user = $this->getUser();
        if(!empty($user)){
            $userId = $user->getId();
        }

        $leconNonPaye = $leconRepository->leconNonPayee($userId)[0][1];
        $leconPaye = $leconRepository->leconPayee($userId)[0][1];
        $leconFaites = $leconRepository->leconFaites($userId)[0][1];
        $leconNonFaites=$leconRepository->leconNonFaites($userId)[0][1];

        return $this->render('stats.html.twig', [
            'leconNonPaye' => json_encode($leconNonPaye),
            'leconPaye' => json_encode($leconPaye),
            'leconFaites' => json_encode($leconFaites),
            'leconNonFaites' => json_encode($leconNonFaites),

        ]);
    }

}