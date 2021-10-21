<?php

namespace App\DataFixtures;

use App\Entity\SAV;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SAVFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for($i=1; $i<=4; $i++){
            $sav= new SAV();
            $sav->setfName($faker->firstName())
                ->setlName($faker->lastName())
                ->setmail($faker->email())
                ->setphone($faker->phoneNumber())
                ->setcategories($faker->jobTitle())
                ->setnumProduct($faker->randomNumber());

            $manager->persist($sav);
        }
        $manager->flush();
    }
}
