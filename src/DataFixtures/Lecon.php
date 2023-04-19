<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class Lecon extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $users = $manager->getRepository(\App\Entity\User::class)->findUsersByEleve();
        $countListUser = count($users);
        $moniteurs = $manager->getRepository(\App\Entity\User::class)->findUsersByMoniteur();
        $countListMoniteur = count($moniteurs);


        for($i = 1; $i <= 1000; $i++) {
            $userId = random_int(0, $countListUser-1);
            $moniteurId = random_int(0, $countListMoniteur-1);

            $lecon = new \App\Entity\Lecon();
            $vehiculeImmatriculation = $this->getReference('vehicule_'. $faker->numberBetween(0,3));
            $lecon->setDate($faker->dateTime);
            $lecon->setHeure($faker->numberBetween(9,18));
            $lecon->setReglee($faker->numberBetween(0,1));
            $lecon->setImmatriculation($vehiculeImmatriculation);
            $lecon->addRelation($users[$userId]);
            $lecon->addRelation($moniteurs[$moniteurId]);
            $manager->persist($lecon);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return
            [
                Vehicule::class,
                User::class

            ];
    }
}
