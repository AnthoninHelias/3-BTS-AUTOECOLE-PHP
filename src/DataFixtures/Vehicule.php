<?php


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Vehicule extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        $vehiculearray =
            [
                0=>["immatriculation"=>"123AB","marque"=>'Renault',"modele"=>'Renaud Twingo',"annee"=>3],
                1=>["immatriculation"=>"589IO","marque"=>'Peugeot',"modele"=>'Peugeot 5008',"annee"=>5],
                2=>["immatriculation"=>"DELETE78","marque"=>'Bateau',"modele"=>'Yatch',"annee"=>2],
                3=>["immatriculation"=>"NULLE","marque"=>'Moto',"modele"=>'T-max',"annee"=>3],
                4=>["immatriculation"=>"NULLE","marque"=>'Camion',"modele"=>'CAM6700',"annee"=>3]
            ];

        foreach ($vehiculearray as $key=>$value)
        {
            $vehicule= new \App\Entity\Vehicule();

            $categorieId = $this->getReference('categorie_'. $faker->numberBetween(0,3));
            $vehicule->setImmatriculation($value["immatriculation"]);
            $vehicule->setMarque($value["marque"]);
            $vehicule->setModele($value["modele"]);
            $vehicule->setAnnee($value["annee"]);
            $vehicule->setIdcategorie($categorieId);

            $this->setReference('vehicule_' . $key , $vehicule);
            $manager->persist($vehicule);


        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return
            [
                Categorie::class
            ];
    }
}
