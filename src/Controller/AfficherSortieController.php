<?php

namespace App\Controller;

use App\Entity\Etat;
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
        $repository = $this->getDoctrine()->getRepository(Etat::class);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('enregistrer')) {
                $etat = $repository->find(1);
            } else if ($form->getClickedButton() === $form->get('publierLaSortie')) {
                $etat = $repository->find(2);
            } else if ($form->getClickedButton() === $form->get('annulerLaSortie')) {
                $etat = $repository->find(6);
                }else {
                    return $this->redirectToRoute('accueil');
                }
                $sortie->setEtat($etat);
                $em->persist($sortie);
                $em->flush();
                return $this->Redirect('http://localhost/Sortir.com/public/afficherSortie/' . $sortie->getId());
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
