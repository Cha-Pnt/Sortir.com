<?php

namespace App\Controller;

use App\Entity\Villes;
use App\Form\VillesType;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GererVillesController extends AbstractController
{
    /**
     * @Route("admin/villes", name="gerer_villes")
     */
    public function addVille(VillesRepository $villesRepository)
    {

//        $villeForm = $this->createForm(VillesType::class, $villes);
//        $villeForm->handleRequest($request);
//        if ($villeForm->isSubmitted() && $villeForm->isValid())
//        {
//            $em->persist($villes);
//            $em->flush();
//
//            return $this->redirectToRoute('gerer_villes');
//        }

        return $this->render('gerer_villes/gererVilles.html.twig', [
//            'filtresForm' => $villeForm->createView(),
            'villes' => $villesRepository->findAll()
        ]);
    }
}
