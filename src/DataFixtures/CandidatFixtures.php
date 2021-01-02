<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CandidatFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $Candidat = new Candidat();
        $Candidat->setFirstname("Jean-luc");
        $Candidat->setLastname("Mélenchon");
        $Candidat->setAge(60);
        $Candidat->setParti("La France insoumise");
        $Candidat->setWiki("...");

        $manager->persist($Candidat);

        $Candidat2 = new Candidat();
        $Candidat2->setFirstname("Emmanuel");
        $Candidat2->setLastname("Macron");
        $Candidat2->setAge(40);
        $Candidat2->setParti("La république en marche!");
        $Candidat2->setWiki("...");

        $manager->persist($Candidat2);

        $Candidat3 = new Candidat();
        $Candidat3->setFirstname("Marine");
        $Candidat3->setLastname("Le Pen");
        $Candidat3->setAge(50);
        $Candidat3->setParti("Rassemblement national");
        $Candidat3->setWiki("...");

        $manager->persist($Candidat3);

        $Candidat4 = new Candidat();
        $Candidat4->setFirstname("Marine");
        $Candidat4->setLastname("Le Pen");
        $Candidat4->setAge(50);
        $Candidat4->setParti("Rassemblement national");
        $Candidat4->setWiki("...");

        $manager->persist($Candidat4);

        $Candidat5 = new Candidat();
        $Candidat5->setFirstname("Marine");
        $Candidat5->setLastname("Le Pen");
        $Candidat5->setAge(50);
        $Candidat5->setParti("Rassemblement national");
        $Candidat5->setWiki("...");

        $manager->persist($Candidat5);

        $Candidat6 = new Candidat();
        $Candidat6->setFirstname("Marine");
        $Candidat6->setLastname("Le Pen");
        $Candidat6->setAge(50);
        $Candidat6->setParti("Rassemblement national");
        $Candidat6->setWiki("...");

        $manager->persist($Candidat6);

        $manager->flush();
    }
}
