<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class Licence extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $moniteurs = $manager->getRepository(\App\Entity\User::class)->findUsersByMoniteur();
        $countListMoniteur = count($moniteurs);

        for($i = 1; $i <= 225; $i++) {
            $userId = random_int(0, $countListMoniteur-1);

            $licence = new \App\Entity\Licence();
            $categorieId = $this->getReference('categorie_'. $faker->numberBetween(0,3));
            $licence->setCodecategorie($categorieId);
            $licence->setRelation($moniteurs[$userId]);
            $licence->setDateobtention($faker->dateTime());
            $manager->persist($licence);
           }
        $manager->flush();
    }
   public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return
            [
                User::class,
                Categorie::class
            ];
    }
}
