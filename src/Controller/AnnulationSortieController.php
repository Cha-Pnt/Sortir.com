<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\AnnulationSortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnnulationSortieController extends AbstractController
{
    /**
     * @Route("/annulation/{id}", name="annulation_sortie", requirements={"id": "\d+"},
     *    )
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function AnnulationSortie(Request $request, $id, SortieRepository $sortieRepo, EntityManagerInterface $em, EtatRepository $etatRepository)
    {

        $annulationForm = $this-> createForm(AnnulationSortieType::class);
        $annulationForm->handleRequest($request);
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        if ($annulationForm->isSubmitted()) {
            $coucou = 'coucou';
            dump($coucou);
            $etat=$etatRepository->find(6);
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute('accueil');
        }
        return $this->render('annulation_sortie/annulation.html.twig', ["annulationForm" => $annulationForm ->createView(), 'sortie' => $sortie
            ]);
    }
}
