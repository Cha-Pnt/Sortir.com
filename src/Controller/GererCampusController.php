<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Form\RechercheCampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/admin", name="admin")
 */
class GererCampusController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/campus", name="gerer_campus")
     */
    public function index(CampusRepository $campusRepository,Request $request)
    {
        $rechercheCampus = $this->createForm(RechercheCampusType::class);
        $rechercheCampus->handleRequest($request);
        if ($rechercheCampus->isSubmitted() && $rechercheCampus->isValid() && !$rechercheCampus['nom']->isEmpty()) {
            $data= $rechercheCampus['nom']->getData();
            $campus = $campusRepository->findByName($data);
        }else{
            $campus = $campusRepository->findAll();
        }

        return $this->render('gerer_campus/index.html.twig', [
            'rechercheCampusForm' => $rechercheCampus->createView(),
            'campus' => $campus
        ]);
    }
    /**
     * @Route("/campus/modify/{id}", name="modify_campus")
     */
    public function modifyCampus(Request $request,Campus $campus)
    {

        $campusForm = $this->createForm(CampusType::class, $campus);
        $campusForm->handleRequest($request);

        if ($campusForm->isSubmitted() && $campusForm->isValid()) {

            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->persist($campus);
            $entityManeger->flush();
            $this->addFlash('message', 'Campus modifié avec succès');
            return $this->redirectToRoute('admingerer_campus');
        }

        return $this->render('gerer_campus/modifyCampus.html.twig', [
            'campusForm' => $campusForm->createView(),
            'campus'=>$campus
        ]);
    }
    /**
     * @Route("/campus/qjouter", name="ajouter_campus")
     */
    public function qjouterCampus(Request $request,EntityManagerInterface $em)
    {
        $campus = new Campus();
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($campus);
            $em->flush();
            return $this->redirectToRoute('admingerer_campus');
        }


        return $this->render('gerer_campus/modifyCampus.html.twig', [
            'campusForm' => $form->createView(),
            'campus'=>null
        ]);

    }
}
