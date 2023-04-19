<?php

namespace App\Controller;
use App\Repository\CategorieRepository;
use App\Repository\LeconRepository;
use App\Repository\LicenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statsMoniteur')]
class StatsMoniteurControlleur  extends AbstractController
{
    #[Route('/', name: 'app_statsMoniteur', methods: ['GET'])]
    public function index(LeconRepository $leconRepository , CategorieRepository $categorieRepository): Response
    {
        $user = $this->getUser();
        if(!empty($user)){
            $userId = $user->getId();
        }

        $nombreLeconDuJour=$leconRepository->lecondujour($userId)[0][1];
        $nombreLeconDelaSemaine=$leconRepository->lecondelasemaine($userId)[0][1];
        $nombreLeconDuMois=$leconRepository->lecondumois($userId)[0][1];
        $nombreLeconDelAnnee=$leconRepository->lecondelanne($userId)[0][1];
        $nombreLeconTotal=$leconRepository->leconTotal($userId)[0][1];
        $chiffreAffaireJourVoiture=$leconRepository->nombreLeconMotoJourUser($userId)[0][1];
        $prixMoto= $categorieRepository->getPrixCat()[0]["prix"];
        $chiffreAffaireJourMoto = $chiffreAffaireJourVoiture * $prixMoto;



        return $this->render('statsMoniteur.html.twig', [
            'nombreLeconDuJour' => json_encode($nombreLeconDuJour),
            'nombreLeconDelaSemaine' => json_encode($nombreLeconDelaSemaine),
            'nombreLeconDuMois' => json_encode($nombreLeconDuMois),
            'nombreLeconDelAnnee' => json_encode($nombreLeconDelAnnee),
            'nombreLeconTotal' => json_encode($nombreLeconTotal),
            'chiffreaffairejourmoto' => json_encode($chiffreAffaireJourMoto),
        ]);
    }

}



