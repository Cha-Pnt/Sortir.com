<?php

namespace App\Controller;

use App\Entity\Villes;
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
    public function addVille(VillesRepository $villesRepository)
    {

        return $this->render('gerer_villes/gererVilles.html.twig', [
            'villes' => $villesRepository->findAll()
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
     * @Route("/ville/supprimer/{id}", name="supprimer_villes")
     */
    public function supprimerVille($id)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$id)
        {
            throw $this->createNotFoundException('No ID found');
        }

        $ville = $em->getRepository('App:Ville')->Find($id);

        if($ville != null)
        {
            $em->remove($ville);
            $em->flush();

            return $this->redirectToRoute('admingerer_villes');

    }

}
