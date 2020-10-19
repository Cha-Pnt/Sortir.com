<?php

namespace App\Controller;


use App\Entity\Inscriptions;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionsController extends AbstractController{


    //Permet de s'inscrire à une sortie
    /**
     * @Route ("/sinscrire/{id}", name="sinscrire")
     * @param $id
     * @param EntityManagerInterface $em
     * @param SortieRepository $repoSortie
     * @param ParticipantRepository $repoParticipant
     * @return Response
     */
    public function actionInscrire($id, EntityManagerInterface $em, SortieRepository $repoSortie, ParticipantRepository $repoParticipant){
            $newInscription = new Inscriptions();
           $sortie =$repoSortie->find($id);
           $user=$this->getUser();
           $newInscription->setParticipant($user);
           $newInscription->setSortie($sortie);
           $em->persist($newInscription);
           $em->flush();
           //Modification du nombre d'inscrits
           $newNbInscrit=$sortie->getNbInscrits()+1;
           $sortie->setNbInscrits($newNbInscrit);
           $em->persist($sortie);
           $em->flush();
        return $this->redirectToRoute('accueil');


    }

    //Permet d'afficher le détail d'une sortie

    /**
     * @Route("/afficherSortie/{id}", name="afficherSortie")
     * @param $id
     * @param SortieRepository $repoSortie
     * @return Response
     */
    public function actionAfficher($id,SortieRepository $repoSortie){
        $sortie =$repoSortie->find($id);
        foreach ($sortie->getInscriptions() as $t){
            dump($t);

        }
        dd('sedtrgftj');

        return $this->redirectToRoute('accueil');

    }

    /**
     * @Route("/desister/{id}", name="desister")
     * @param $id
     * @param EntityManagerInterface $em
     * @param SortieRepository $repoSortie
     * @param InscriptionsRepository $repoInscription
     */
    public function actionDesister($id, EntityManagerInterface $em, SortieRepository $repoSortie, InscriptionsRepository $repoInscription)
    {

        $user = $this->getUser();
        $sortie = $repoSortie->find($id);
        $inscription = $repoInscription->findByParameters($user, $sortie);
        $sortie->setNbInscrits($sortie->getNbInscrits() - 1);
        $em->persist($sortie);
        //dd($inscription);
        foreach($inscription as $inscriptions){
            $em->remove($inscriptions);
            $em->flush();
        }


        return $this->redirectToRoute('accueil');
    }
}