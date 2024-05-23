<?php

namespace App\DataFixtures;

use App\Entity\Prestataire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PrestataireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++)
        {
            $prestataire = new Prestataire();
            $prestataire->setNomPrestataire("Prestataire numéro $i")
                         ->setTypePrestataire("Type du prestataire n°$i")
                         ->setInfoPrestataire("Numéro du prestataire n°$i");
            $manager->persist($prestataire);
            $manager->flush();
            

        
    }
}
}
