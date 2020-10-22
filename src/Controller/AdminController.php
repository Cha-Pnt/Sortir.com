<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ModifierUtilisateurType;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin", name="admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
    /**
     * Liste des utilisateurs du site
     * @Route ("/utilisateurs", name="utilisateurs")
     */
    public function userList(ParticipantRepository $participantRepository){
        return $this->render("admin/utilisateurs.html.twig",[
            'utilisateurs' => $participantRepository->findAll()
        ]);

    }
    /**
     * Modifier un utilisateur
     * @Route ("/utilisateur/modifier/{id}", name="modifier_utilisateur")
     */
    public function modifierUtilisateur(Participant $user, Request $request){
        $form = $this->createForm(ModifierUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->persist($user);
            $entityManeger->flush();
            $this->addFlash('message','Utilisateur modifié avec succès');
            return $this->redirectToRoute('adminutilisateurs');

        }
        return $this->render('admin/modifierUtilisateur.html.twig',[
            'userForm' => $form->createView()
        ]);
    }
}
