<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\CreateSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateSortieController extends AbstractController
{
    /**
     * @Route("/createSortie", name="create_sortie")
     */
    public function index(Request $request,EntityManagerInterface $em)
    {
        $sortie = new Sortie();
        $form = $this->createForm(CreateSortieType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY')){
                $sortie->setOrganisateur($this->getUser());
            }

            $em->persist($sortie);
            $em->flush();
            return $this->Redirect('accueil');
        }

        return $this->render('create_sortie/index.html.twig', [
            'controller_name' => 'CreateSortieController',
            'formSortie' => $form->createView()
        ]);
    }
}
