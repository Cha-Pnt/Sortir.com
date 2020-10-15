<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\ChercherSortieType;
use App\Repository\SortieRepository;
use http\Env\Response;
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
    public function chercherSortie(Request $request, SortieRepository $sortieRepo)
    {
        $sortie = new Sortie();
        $rechercherForm = $this ->createForm(ChercherSortieType::class, $sortie);
        $rechercherForm->handleRequest($request);
        if($rechercherForm->isSubmitted() or $rechercherForm->isValid()) {
            $parametres=$rechercherForm->getData();
            $listeSorties=$sortieRepo->findByParametres($parametres);
            return $this->redirectToRoute('accueil', array('listeSorties'=>[$listeSorties]));
        }

        return $this->render('accueil/accueil.html.twig', [
            "rechercherForm" => $rechercherForm -> createView()
        ]);
    }

    ///**
     //* @Route("/accueil", name="accueil")
     //*/
    //public function afficherSortie()
    //{

    //}

}
