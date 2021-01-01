<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $User = new User();
        $User->setEmail("test@test.fr");
        $User->setPassword("aaa");

        $manager->persist($User);
        $manager->flush();
    }
}
