<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationLieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="creation_lieu")
     */
    public function ajouterLieu(Request $request,EntityManagerInterface $em)
    {
        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class, $lieu);

        $lieuForm->handleRequest($request);
        if($lieuForm->isSubmitted() && $lieuForm->isValid())
        {
            $em->persist($lieu);
            $em->flush();

            return $this->redirectToRoute('create_sortie');
        }

        return $this->render('creation_lieu/lieu.html.twig', [
            'lieuForm' => $lieuForm->createView()
        ]);
    }
}
