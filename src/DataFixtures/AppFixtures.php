<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $marque1 = New Marque();
        $marque1 ->setLibelle('Yotota');
        $manager->persist($marque1);
        
        $marque2 = New Marque();
        $marque2 ->setLibelle('Jeupo');
        $manager->persist($marque2);

        $modele1 = New Modele();
        $modele1 ->setLibelle('Rayis')
                ->setImage('modeles1.jpg')
                ->setPrixMoyen(15000)
                ->setMarque($marque1);
        $manager->persist($modele1);

        $modele2 = New Modele();
        $modele2 ->setLibelle('Yraus')
                ->setImage('modeles2.jpg')
                ->setPrixMoyen(20000)
                ->setMarque($marque1);
        $manager->persist($modele2);

        $modele3 = New Modele();
        $modele3 ->setLibelle('007')
                ->setImage('modeles3.jpg')
                ->setPrixMoyen(30000)
                ->setMarque($marque1);
        $manager->persist($modele3);

        $modele4 = New Modele();
        $modele4 ->setLibelle('008')
                ->setImage('modeles4.jpg')
                ->setPrixMoyen(10000)
                ->setMarque($marque1);
        $manager->persist($modele4);

        $modele5 = New Modele();
        $modele5 ->setLibelle('009')
                ->setImage('modeles5.jpg')
                ->setPrixMoyen(17000)
                ->setMarque($marque1);
        $manager->persist($modele5);

        $faker = \Faker\Factory::create('fr_FR');

        $modeles = [$modele1,$modele2,$modele3,$modele4,$modele5];
        foreach ($modeles as $m) {
            $rand = rand(3,5);
            for ($i=1; $i <= $rand ; $i++) { 
                $voiture = New Voiture();
                $voiture->setImmatriculation($faker->regexify('[A-Z]{2}[0-9]{3,4}[A-Z]{2}'))
                        ->setNbPortes($faker->randomElement($array = array(3,5)))
                        ->setAnnee($faker->numberBetween($min = 1990, $max = 2021))
                        ->setModele($m);
                $manager->persist($voiture);
            }
        }
        



        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
