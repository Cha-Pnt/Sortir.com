<?php

namespace App\Controller;
use App\Entity\Participant;
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
                $sortie->setOrganisateur($this->getUser());
                $sortie->getInscriptions(0);
                $em->persist($sortie);
                $em->flush();
            return $this->redirectToRoute('accueil');

        }
        return $this->render('create_sortie/index.html.twig', [
            'formSortie' => $form->createView()
        ]);
    }
}
