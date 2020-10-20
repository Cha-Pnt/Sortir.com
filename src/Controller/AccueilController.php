<?php

namespace App\Controller;

use App\Data\Recherche;
use App\Entity\Archive;
use App\Entity\Etat;
use App\Form\FiltresSortieType;
use App\Repository\ArchiveRepository;
use App\Repository\EtatRepository;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param EntityManagerInterface $em
     * @param SortieRepository $sortieRepo
     * @param ParticipantRepository $participantRepository
     * @param InscriptionsRepository $repoInscriptions
     * @param EtatRepository $repoEtat
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affichageSortie(Request $request, EntityManagerInterface $em,SortieRepository $sortieRepo, ParticipantRepository $participantRepository,InscriptionsRepository $repoInscriptions,EtatRepository $repoEtat)
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
                    //vérifie l'état de la sortie
                    if($sortie->getDateHeureDebut() < $dateActuelle && $sortie->getEtat()->getLibelle() != "Annulée"){
                        $sortie->setEtat($etatPasse);
                        //Vérifie l'état des sorties en fonction de la date
                    }else if ($sortie->getDateLimite() < $dateActuelle && $sortie->getDateHeureDebut() > $dateActuelle ){
                        $etatPasse = $repoEtat->findOneBy(['libelle'=>'clôturée']);
                        $sortie->setEtat($etatPasse);
                        //Vérifie si la sortie s'est finie depuis au moins 1 moins si oui elle est archivée et supprimée de la liste des sorties
                    }else if($sortie->getDateHeureDebut()->diff($dateActuelle)->m >= 1 ){
                        $archive = new Archive();
                        $archive->setNom($sortie->getNom());
                        $archive->setCampus($sortie->getCampus());
                        $archive->setDateDebut($sortie->getDateHeureDebut());
                        $archive->setDateCloture($sortie->getDateLimite());
                        $archive->setDuree($sortie->getDuree());
                        $archive->setEtat($sortie->getEtat());
                        $archive->setLieu($sortie->getLieu());
                        $em->persist($archive);
                        $em->remove($sortie);
                        $em->flush();
                        return $this->redirectToRoute('accueil');
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
}
