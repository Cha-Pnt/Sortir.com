<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\AfficherSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AfficherSortieController extends AbstractController
{
    /**
     * @Route("/modifierSortie/{id}", name="modifierSortie")
     */
    public function index(Request $request,EntityManagerInterface $em, Sortie $sortie)
    {
        $form = $this->createForm(AfficherSortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sortie);
            $em->flush();
            return $this->Redirect('afficherProfil/'.$sortie->getId());
        }

        return $this->render('afficher_sortie/index.html.twig', [
            'formSortie' => $form->createView()
        ]);
    }

    /**
     * @Route("/afficherSortie/{id}", name="afficherSortie")
     */
    public function afficherSortie(Sortie $sortie)
    {
        return $this->render('afficher_sortie/afficheDetailSortie.html.twig', [
            'sortie' => $sortie
        ]);

    }
}
