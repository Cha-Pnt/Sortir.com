<?php

namespace App\Controller;

use App\Data\Recherche;
use App\Entity\Participant;
use App\Form\FiltresSortieType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use http\Env\Response;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{


    /**
     * @Route("/accueil", name="accueil")
     * @param Request $request
     * @param SortieRepository $sortieRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function chercherSortie(Request $request, SortieRepository $sortieRepo, ParticipantRepository $participantRepository)
    {
        $recherche = new Recherche();
        $user = $this->getUser()->getId();
        $rechercherForm = $this->createForm(FiltresSortieType::class, $recherche);
        $rechercherForm->handleRequest($request);

        if($rechercherForm->isSubmitted()) {
            $parametres=$rechercherForm->getData();
           $listeSorties=$sortieRepo->findByParametres($parametres,$user,$participantRepository);
            return $this->render('accueil/accueil.html.twig', [
                    "rechercherForm" => $rechercherForm->createView(),'listeSorties'=>$listeSorties,'user'=>$this->getUser()]
            );
        }else {
                $listeSorties = $sortieRepo->findAll();
                return $this->render('accueil/accueil.html.twig', [
                    "rechercherForm" => $rechercherForm->createView(),'listeSorties'=>$listeSorties,'user'=>$this->getUser()]
            );
        }
    }

    ///**
     //* @Route("/accueil", name="accueil")
     //*/
    //public function afficherSortie()
    //{

    //}

}
