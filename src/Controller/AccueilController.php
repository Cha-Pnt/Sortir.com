<?php

namespace App\Controller;

use App\Data\Recherche;
use App\Entity\Etat;
use App\Form\FiltresSortieType;
use App\Repository\EtatRepository;
use App\Repository\InscriptionsRepository;
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
     * @param ParticipantRepository $participantRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Form\Exception\RuntimeException
     */
    public function chercherSortie(Request $request, SortieRepository $sortieRepo, ParticipantRepository $participantRepository,InscriptionsRepository $repoInscriptions,EtatRepository $repoEtat)
    {
        $recherche = new Recherche();
        //Liste les inscriptions de l'utilisateur connecté
        $user = $this->getUser();
        $listeInscriptionsUser=[];
        $listeInscriptions=$repoInscriptions->findAll();
        foreach ($listeInscriptions as $inscription){
            if ($inscription->getParticipant() == $user ){
                $listeInscriptionsUser[]=$inscription;
            }
        }
        //dd($listeInscriptionsUser);
        $tableauSortiesInscrits=[];

        //Création d'un tableau des id des sorties auquel l'utilisateur s'est inscrit
        if($listeInscriptionsUser != null){
            foreach ($listeInscriptionsUser as $inscription) {
                $tableauSortiesInscrits[] = $inscription->getSortie()->getId();
            }
        }

        //Initialisation de la date du jour
        $dateActuelle = new \Datetime;
        //Creation du formulaire
        $filtresForm = $this->createForm(FiltresSortieType::class, $recherche);
        $filtresForm->handleRequest($request);

        if($filtresForm->isSubmitted()) {
            $parametres=$filtresForm->getData();
           $listeSorties=$sortieRepo->findByParametres($parametres,$user,$participantRepository);
            return $this->render('accueil/accueil.html.twig', [
                    "filtresForm" => $filtresForm->createView(),
                    'listeSorties'=>$listeSorties,'user'=>$this->getUser(),
                    'listeInscriptions'=>$tableauSortiesInscrits,
                    'dateActuelle'=>$dateActuelle]
            );
        }else {
            //Affichage de la liste des sorties
                $listeSorties = $sortieRepo->findAll();
                $etatPasse = $repoEtat->findOneBy(['libelle'=>'passée']);
                foreach ($listeSorties as $sortie){
                    if($sortie->getDateHeureDebut() < $dateActuelle ){
                        $sortie->setEtat($etatPasse);
                    }elseif ($sortie->getDateLimite() < $dateActuelle && $sortie->getDateHeureDebut() > $dateActuelle ){
                        $etatPasse = $repoEtat->findOneBy(['libelle'=>'clôturée']);
                        $sortie->setEtat($etatPasse);
                    }
                }
                return $this->render('accueil/accueil.html.twig', [
                    "filtresForm" => $filtresForm->createView(),
                        'listeSorties'=>$listeSorties,'user'=>$this->getUser(),
                        'listeInscriptions'=>$tableauSortiesInscrits,
                        'dateActuelle'=>$dateActuelle]
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
