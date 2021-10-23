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

        for($i=1; $i<=45; $i++){
            $sav= new SAV();
            $sav->setfName($faker->firstName())
                ->setlName($faker->lastName())
                ->setmail($faker->email())
                ->setphone($faker->phoneNumber())
                ->setcategories($faker->numberBetween(0,4))
                ->setnumProduct($faker->uuid())
                ->setDate($faker->dateTimeBetween('now','+2 days'))
                ->setDayMoment($faker->numberBetween(0,2));
               
                $manager->persist($sav);
        }
        $manager->flush();
    }
}
