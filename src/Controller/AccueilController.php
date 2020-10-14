<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\ChercherSortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function chercherSortie()
    {
        $sortie = new Sortie();
        $rechercherForm = $this ->createForm(ChercherSortieType::class, $sortie);


        return $this->render('accueil/accueil.html.twig', [
            "rechercherForm" => $rechercherForm -> createView()
        ]);
    }
}
