<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sortie = new Sortie();
        $sortie->setNom(Philo);
        $sortie->setDateHeureDebut(20/10/2020);
        $sortie->setDuree(2);
        $sortie->setDateLimite(20/10/2020);
        $sortie->setNbInscriptionsMax(8);
        $sortie->setDescription('Le dilemme du tramway vous connaissez ?');
        $sortie->setEtat('Ouverte');
        $sortie->setLieu('Île du docteur Moreau');
        $sortie->setCampus('Nantes');
        $sortie->setOrganisateur('Spinoz A.');
        $manager->persist($sortie);

        $manager->flush();
    }
}
