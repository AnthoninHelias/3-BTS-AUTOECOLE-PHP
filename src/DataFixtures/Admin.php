<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Admin extends Fixture
{

    private UserPasswordHasherInterface $hasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->hasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager,["ROLE_ADMIN"],"1");
    }
    public function loadUser(ObjectManager $manager, array $role, int $count): void {
        $faker = Factory::create();


            $user = new \App\Entity\User();
            $user->setEmail('admin@admin.com');
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setPassword($this->hasher->hashPassword($user , "admin"));
            $user->setSexe(rand(0, 2));
            $user->setRoles($role);
            $manager->persist($user);
            //add reference ajoute une reference a l'objet afin de pouvoir l'utilisé dans d'autre facker avec des relations
            $this->setReference('user_'. 999999 , $user);
            //$this->addReference('user_'. 1 ,$user);




        $manager->flush();
    }
}






