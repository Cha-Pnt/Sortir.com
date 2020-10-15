<?php

namespace App\DataFixtures;


use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $user= new Participant();
        $campus = new Campus();
        $campus->setNom('Campus Lyon');
        $user->setCampus($campus);
        $user->setActif(true);
        $user->setAdministrateur(false);
        $user->setMail('jbponzio@hotmail.fr');
        $user->setNom('PONZIO');
        $user->setPrenom('JB');
        $user->setPassword('123');
        $user->setPhone('0637337873');
        $user->setPseudo('jb');
        $manager->persist($campus);
        $manager->persist($user);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
