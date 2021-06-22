<?php

namespace App\DataFixtures;
use App\Entity\Poste;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        // $postes=[];
        $users=[];

        for ($i=0; $i < 5 ; $i++) {
            $user=new User();
            $user->setEmail($faker->email);
            $user->setPassword(123456789);
            $user->setLastname($faker->lastName());
            $manager->persist($user);
            $users[]=$user;
        }

        for ($i=0; $i < 50 ; $i++) { 
            $poste = new Poste();
            $poste->setTitle($faker->text(50));
            $poste->setContent($faker->text(400));
            $poste->setImage($faker->imageUrl());
            $poste->setCreatedAt(new \DateTimeImmutable());
            $poste->setAuthor($users[$faker->numberBetween(0,4)]);
            $manager->persist($poste);
        }

        $manager->flush();
    }
}
