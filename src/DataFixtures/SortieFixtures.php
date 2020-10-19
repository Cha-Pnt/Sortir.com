<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sortie = new Sortie();

        $etat = new Etat();
        $etat->getId();

        $participant = new Participant();
        $participant->getId();

        $lieu = new Lieu();
        $lieu->getId();

        $campus = new Campus();
        $campus->getId();

        $sortie->setNom('Philo');
        $sortie->setDateHeureDebut(new \DateTime('2020-10-20 20:30'));
        $sortie->setDuree(2);
        $sortie->setDateLimite(new \DateTime('2020-10-20'));
        $sortie->setNbInscriptionsMax(8);
        $sortie->setDescription('Le dilemme du tramway vous connaissez ?');
        $sortie->setEtat($etat);
        $sortie->setLieu($lieu);
        $sortie->setCampus($campus);
        $sortie->setOrganisateur($participant);

        $manager->persist($sortie);

        $manager->flush();
    }
}
