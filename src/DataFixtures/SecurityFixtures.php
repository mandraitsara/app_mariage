<?php

namespace App\DataFixtures;

use App\Entity\UserLogin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer un utilisateur avec le rôle ADMIN
        $admin = new UserLogin();
        $admin->setUsername('Administrateur')
            ->setEmail('administrateur+1@gmail.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        // Encodage du mot de pass
        $password = $this->passwordHasher->hashPassword($admin, 'admintest');
        $admin->setPassword($password);

        $manager->persist($admin);

        // D'autres utilisateurs peuvent être créés de la même manière si nécessaire

        $manager->flush();
    }
}
