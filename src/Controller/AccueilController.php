<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\ChercherSortieType;
use App\Form\RechercheFormType;
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
    public function chercherSortie(Request $request, SortieRepository $sortieRepo)
    {
        $sortie = new Sortie();
        $user = $this->getUser();
        $rechercherForm = $this ->createForm(RechercheFormType::class, $sortie);
        $rechercherForm->handleRequest($request);

        if($rechercherForm->isSubmitted() && $rechercherForm->isValid()) {
            $parametres=$rechercherForm->getData();
            $listeSorties=$sortieRepo->findByParametres($parametres,$user);
            return $this->redirectToRoute('accueil', array('listeSorties'=>[$listeSorties],'user'=>[$user]));
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
