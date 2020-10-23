<?php

namespace App\Controller;

use App\Entity\Villes;
use App\Form\RechercheVilleType;
use App\Form\VillesType;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin")
 */
class GererVillesController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/villes", name="gerer_villes")
     */
    public function addVille(VillesRepository $villesRepository, Request $request)
    {
        $rechercheVille = $this->createForm(RechercheVilleType::class);
        $rechercheVille->handleRequest($request);
        if ($rechercheVille->isSubmitted() && $rechercheVille->isValid() && !$rechercheVille['nom']->isEmpty()) {
            $data= $rechercheVille['nom']->getData();
            $villes = $villesRepository->findByName($data);
        }else{
            $villes = $villesRepository->findAll();
        }

        return $this->render('gerer_villes/gererVilles.html.twig', [
            'rechercheVilleForm' => $rechercheVille->createView(),
            'villes' => $villes
        ]);
    }

    /**
     * @Route("/ville/modify/{id}", name="modify_villes")
     */
    public function modifyVille(Request $request,Villes $ville)
    {

        $villeForm = $this->createForm(VillesType::class, $ville);
        $villeForm->handleRequest($request);

        if ($villeForm->isSubmitted() && $villeForm->isValid()) {

            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->persist($ville);
            $entityManeger->flush();
            $this->addFlash('message', 'Ville modifié avec succès');
            return $this->redirectToRoute('admingerer_villes');
        }

        return $this->render('gerer_villes/modifyVille.html.twig', [
            'villeForm' => $villeForm->createView(),
            'ville'=>$ville
        ]);
    }
    /**
     * @Route("/ville/qjouter", name="ajouter_villes")
     */
    public function qjouterVille(Request $request,EntityManagerInterface $em)
    {
        $ville = new Villes();
        $form = $this->createForm(VillesType::class, $ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ville);
            $em->flush();
            return $this->redirectToRoute('admingerer_villes');
        }


        return $this->render('gerer_villes/modifyVille.html.twig', [
        'villeForm' => $form->createView(),
            'ville'=>null
    ]);

    }

}
