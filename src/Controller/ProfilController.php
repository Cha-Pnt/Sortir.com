<?php

namespace App\Controller;

use App\Entity\Participant;


use App\Form\ProfilFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function index(Participant $user,EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
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
            return $this->Redirect('afficherProfil/'.$user->getId());
        }
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("profil/afficherProfil/{id}", name="afficherProfil")
     */
    public function afficherProfil(Participant $user){
        return $this->render('profil/afficherProfil.html.twig', [
            'user' => $user
        ]);

    }
}
