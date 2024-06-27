<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Categorie;
use App\Entity\Prestataire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PrestataireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de catégories
        for ($i = 1; $i <= 5; $i++) {
            $categorie = new Categorie();
            $categorie->setTitreCategorie('Titre Categorie ' . $i)
                ->setSoustitreCategorie('Sous-titre Categorie ' . $i)
                ->setContent('<p>Contenu de la catégorie ' . $i . '</p>');
            $manager->persist($categorie);

            // Création de contacts et de prestataires pour chaque catégorie
            for ($k = 1; $k <= 5; $k++) {
                $contact = new Contact();
                $contact->setNom('Nom Contact ' . $k)
                    ->setAdresse('Adresse Contact ' . $k)
                    ->setMail('contact' . $k . '@example.com');
                $manager->persist($contact);

                // Création de prestataires
                for ($j = 1; $j <= 5; $j++) {
                    $prestataire = new Prestataire();
                    $prestataire->setNomPrestataire('Nom Prestataire ' . $j)
                        ->setTypePrestataire('Type Prestataire ' . $j)
                        ->setInfoPrestataire('Info Prestataire ' . $j)
                        ->setCategorie($categorie)
                        ->setContact($contact);
                    $manager->persist($prestataire);
                }
            }
        }

        $manager->flush();
    }
}
