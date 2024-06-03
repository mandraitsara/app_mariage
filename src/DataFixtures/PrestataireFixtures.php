<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Categorie;
use App\Entity\Prestataire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class PrestataireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Création catégorie 

        for ($i = 0; $i <= 5; $i++) {
            $categorie = new Categorie();

            $content = '<p>';
            $content = '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>';
            $content = '</p>';

            $categorie->setTitreCategorie($faker->sentence())
                ->setSoustitreCategorie($faker->paragraph())
                ->setContent($content);
            $manager->persist($categorie);
        }

        // Création de contact 
        for ($k = 1; $k <= mt_rand(4, 6); $k++) {
            $contact = new Contact();
            $contact->setnom($faker->name())
                ->setadresse($faker->address())
                ->setmail($faker->email());
            $manager->persist($contact);
        }

        // Création article 
        for ($j = 1; $j <= mt_rand(4, 6); $j++) {
            $prestataire = new Prestataire();
            $prestataire->setNomPrestataire($faker->name())
                ->setTypePrestataire($faker->sentence())
                ->setInfoPrestataire($faker->sentence())
                ->setCategorie($categorie)
                ->setContact($contact);
            $manager->persist($prestataire);
        }

        $manager->flush();
    }
}
