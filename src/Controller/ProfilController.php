<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $user = new Participant();
        $form = $this->createFormBuilder($user)
            ->add('Pseudo')
            ->add('Nom')
            ->add('Prenom')
            ->add('Phone')
            ->add('Mail')
            ->add('Password')
            ->add('Campus' , EntityType::class,['class'=>Campus::class])

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            
            $user->setActif(true);
            $user->setAdministrateur(false);


            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('/accueil');
        }
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'formUser' => $form->createView()
        ]);
    }
}
