<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ResetType;
use App\Entity\UserLogin;
use App\Form\InscriptionType;
use App\Form\ResetPasswordType;
use App\Service\SendMailService;
use Symfony\Component\Mime\Email;
use App\Repository\UserLoginRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class IdentificationController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security, Request $request): Response
    {
        // Vérifier si l'utilisateur est déjà authentifié
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Rediriger vers la page d'accueil s'il est déjà authentifié
            return $this->redirectToRoute('home.plan_mariage');
        }

        // $error = $authenticationUtils->getLastAuthenticationError();
        $error = '';
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/deconnexion', name: 'app_logout')]
    public function logout()
    {
    }

    #[Route('/inscr', name: 'app_inscr')]
    public function inscription(Request $request, ObjectManager $manager, UserPasswordHasherInterface $passwordHasher,): Response
    {
        $user = new UserLogin();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);        

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();            
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());

            $user->setPassword($hashedPassword);

            $newActive = new Activity();

            $user->getActivities()->add($newActive);
            $new = $newActive->setUser($user);



            $manager->persist($new);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'security/inscr.html.twig',
            [
                'form' => $form
            ]
        );
    }

    #[Route('/mdp_oublie', name: 'app_mdp_oublie')]
    public function mdp_oublie(
        Request $request,
        UserLoginRepository $userLoginRepository,
        TokenGeneratorInterface $tokenGeneratorInterface,
        EntityManagerInterface $entityManager,
        SendMailService $emailService,
        MailerInterface $mailer
    ): Response {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userLoginRepository->findOneByEmail($form->get('email')->getData());

            if ($user) {
                $token = $tokenGeneratorInterface->generateToken();

                if ($token) {
                    $user->setResetToken($token);
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $url = $this->generateUrl('app_reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                    $context = compact('url', 'user');

                    $email = (new Email())
                        ->from('mixellorak9@gmail.com')
                        ->to($user->getEmail())
                        ->subject('Réinitialisation de mot de passe')
                        ->html($this->renderView('security/passwordreset.html.twig', $context));

                    $mailer->send($email);

                    $this->addFlash('success', 'Un email de réinitialisation de mot de passe a été envoyé.');
                    return $this->redirectToRoute('app_login');
                } else {
                    $this->addFlash('danger', 'Erreur lors de la génération du token.');
                }
            } else {
                $this->addFlash('danger', 'Utilisateur non trouvé.');
            }
        }

        return $this->render('security/resetpassword.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('oubliepassword/{token}', name: 'app_reset_pass')]
    public function reset_pass(
        string $token,
        Request $request,
        UserLoginRepository $userLoginRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $userLoginRepository->findOneByResetToken($token);

        if (!$user) {
            $this->addFlash('danger', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setResetToken(null);
            $user->setPassword($passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            ));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe réinitialisé avec succès.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/resettypepassword.html.twig', [
            'passForm' => $form->createView()
        ]);
    }
}
