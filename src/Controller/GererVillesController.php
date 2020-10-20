<?php

namespace App\Controller;

use App\Entity\Villes;
use App\Form\VillesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GererVillesController extends AbstractController
{
    /**
     * @Route("/villes", name="gerer_villes")
     */
    public function addVille(EntityManagerInterface $em, Request $request)
    {
        $ville= new Villes();

        $villeForm = $this->createForm(VillesType::class, $ville);
        $villeForm->handleRequest($request);
        if ($villeForm->isSubmitted() && $villeForm->isValid())
        {
            $em->persist($ville);
            $em->flush();

            return $this->redirectToRoute('gerer_villes');
        }

        return $this->render('gerer_villes/gererVilles.html.twig', [
            'controller_name' => 'GererVillesController',
        ]);
    }
}
