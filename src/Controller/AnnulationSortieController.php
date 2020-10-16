<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\AnnulationSortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnnulationSortieController extends AbstractController
{
    /**
     * @Route("/annulation", name="annulation_sortie")
     */
    public function AnnulationSortie(Request $request)
    {
        $sortie = new Sortie();
        $annulationForm = $this-> createForm(AnnulationSortieType::class, $sortie);
        $annulationForm->handleRequest($request);

        if($annulationForm->isSubmitted() && $annulationForm->isValid())



        return $this->render('annulation_sortie/annulation.html.twig', [
            'controller_name' => 'AnnulationSortieController',
        ]);
    }
}
