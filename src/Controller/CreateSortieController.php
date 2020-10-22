<?php

namespace App\Controller;
use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\CreateSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class CreateSortieController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/createSortie", name="create_sortie")
     */
    public function index(Request $request,EntityManagerInterface $em)
    {
        $sortie = new Sortie();
        $form = $this->createForm(CreateSortieType::class, $sortie);

        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(Etat::class);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('enregistrer')){
                $etat = $repository->find(1);
            }else if ($form->getClickedButton() === $form->get('publierLaSortie')){
                $etat = $repository->find(2);
            }else{
                return $this->redirectToRoute('accueil');
            }
                $sortie->setEtat($etat);
                $sortie->setOrganisateur($this->getUser());
                $em->persist($sortie);
                $em->flush();
            return $this->redirectToRoute('accueil');

        }
        return $this->render('create_sortie/index.html.twig', [
            'formSortie' => $form->createView()
        ]);
    }
}
