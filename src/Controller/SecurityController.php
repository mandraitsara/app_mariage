<?php

namespace App\Controller;

use App\Entity\UserLogin;
use App\Form\InscriptionType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
       
        return $this->render('security/login.html.twig');
    }


    #[Route('/inscr', name: 'app_inscr')]
    public function inscription (Request $request, ObjectManager $manager, UserPasswordHasherInterface $passwordHasher, ): Response
    {
        $user = new UserLogin();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $user = $form->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            
            $user->setPassword($hashedPassword);          

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        } 

        return $this->render('security/inscr.html.twig', 
        [
            'form'=> $form
        ]);

    }

}
