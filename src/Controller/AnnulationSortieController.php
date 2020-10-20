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
    public function AnnulationSortie(Request $request, Sortie $sortie, EntityManagerInterface $em)
    {

        $annulationForm = $this-> createForm(AnnulationSortieType::class,$sortie);
        $annulationForm->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(Etat::class);

        if ($annulationForm->isSubmitted()) {
            $etat=$repository->find(7);
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute('accueil');
        }
        return $this->render('annulation_sortie/annulation.html.twig',
            ["annulationForm" => $annulationForm ->createView(),
                'sortie' => $sortie
            ]);
    }
}
