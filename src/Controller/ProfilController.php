<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;


use App\Form\ProfilFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     * @Route("/profil/{id}", name="profil_edit")
     */
    public function index(Participant $user,EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        //$user = new Participant();
        $form = $this->createForm(ProfilFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setAdministrateur(false);
            $user->setActif(true);
            $em->persist($user);
            $em->flush();
            return $this->Redirect('profil');
        }
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'formUser' => $form->createView()
        ]);
    }
    /**
     * @Route("/AfficherProfil", name="profil")
     */
    public function afficherProfil(){
        return $this->render('profil/afficherProfil.html.twig');
    }
}
