<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Categorie extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $categoriearray =
            [
                0=>["libelle"=>"bateau","prix"=>45,"codecategorie"=>1],
                1=>["libelle"=>"moto","prix"=>44,"codecategorie"=>2],
                2=>["libelle"=>"camion","prix"=>90,"codecategorie"=>3],
                3=>["libelle"=>"voiture","prix"=>666,"codecategorie"=>4]
            ];
        foreach ($categoriearray as $key=>$value)
        {
            $categorie = new \App\Entity\Categorie();


            $categorie->setLibelle($value["libelle"]);
            $categorie->setPrix($value["prix"]);
            $categorie->setCodecategorie($value["codecategorie"]);
            $this->setReference('categorie_'.$key,$categorie);
            $manager->persist($categorie);
        }
        $manager->flush();
    }
}
