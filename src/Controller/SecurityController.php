<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Form\ResetType;
use App\Entity\UserLogin;
use App\Form\InscriptionType;
use App\Form\ResetPasswordType;
use App\Service\SendMailService;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\UserLoginRepository;
use Doctrine\Persistence\ObjectManager;
=======
//use App\Form\MDPType;
use App\Entity\UserLogin;
use App\Form\InscriptionType;
use App\Form\ResetpasswordType;
//use Doctrine\ORM\EntityManagerInterface;
use App\Service_Mail\SendEmail;
use App\Service\SendEmailService;
use App\Repository\UserLoginRepository;
use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\Security\Http\Logout\LogoutUtils;
//use Symfony\Component\Form\Extension\Core\Type\ResetType;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Logout\LogoutUtils;
=======
>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
<<<<<<< HEAD

=======
//use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71

class SecurityController extends AbstractController
{
    // CONNEXION
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security, Request $request ): Response
    {
 

    
       if ($security->isGranted('ROLE_USER')) {
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
    // DECONNEXION 
    #[Route('/deconnexion', name:'app_logout')]
    public function logout()
    {

    }
    // INSCRIPTION
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

<<<<<<< HEAD
    #[Route('/mdp_oublie', name: 'app_mdp_oublie')]
    public function mdp_oublie(Request $request, 
                               UserLoginRepository $userLoginRepository, 
                               TokenGeneratorInterface $tokenGeneratorInterface, 
                               EntityManagerInterface $entityManager, 
                               SendMailService $emailService, 
                               MailerInterface $mailer): Response
    {
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
    public function reset_pass(string $token, 
                              Request $request, 
                              UserLoginRepository $userLoginRepository, 
                              UserPasswordHasherInterface $passwordHasher, 
                              EntityManagerInterface $entityManager): Response
    {
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


=======
    // MOT DE PASSE  OUBLIE
    #[Route('/mdp_oublie', name:'app_mdp_oublie')]
    public function mdpoublie(Request $request, 
                            UserLoginRepository $userLoginRepository, 
                            TokenGeneratorInterface $tokenGeneratorInterface, 
                            EntityManagerInterface $entityManager, 
                            SendEMailService $email 
                            
    ): Response
    {
        $form = $this->createForm(ResetpasswordType::class);
        // Eto no manao recupération anle donnée anaty formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // maka anle utilisateur eto am mail
            $user = $userLoginRepository ->findOneByEmail($form->get('email')-> getData());
            // vérification raha misy user connécté ato
            if($user)
            {
                // génération anle token de réinitialisation 
                $token = $tokenGeneratorInterface ->generateToken();
                //dd($token);
                
                $user->setResetToken($token); 
                //$user->setResetToken($token);
                
                $entityManager ->persist($user);
                $entityManager->flush();
               
                // Génération lien anle réinitialisation mdp no eto
                $url = $this->generateUrl('app_reset_passs', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                //dd($url);
                // Création donnée anle mail no ato
                $context = compact('url', 'user');
                //dd($user);
                // Envoi mail no eto 
                $email->sendEmail(
                    'mixellorak9@gmail.com',
                    $user->getEmail(),
                    'Réinitialisation de mot de passe',
                    'password_reset',
                    $context
                );
                
                $this->addFlash('success', 'Email OK');
                return $this->redirectToRoute('app_login');

            } else 
            // Eto raha tsy misy user azo
                $this->addFlash('danger', 'Erreur : utilisateur non trouvé.');
                return $this->redirectToRoute('app_login');
        }
        return $this->render ('security/resetpassword.html.twig', [
            'requestPassForm'=>$form
        ]);
    }
    #[Route('/oubliepass/{token}', name:'app_reset_passs')]
    public function resetPass(
        string $token,
        Request $request,
        UserLoginRepository $usersRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) : Response
    {
    
        {
            // On vérifie si on a ce token dans la base
            $user = $usersRepository->findOneByResetToken($token);
            
            // On vérifie si l'utilisateur existe
    
            if($user){
                $form = $this->createForm(ResetPasswordType::class);
    
                $form->handleRequest($request);
    
                if($form->isSubmitted() && $form->isValid()){
                    // On efface le token
                    $user->setResetToken('');
                    
                    
    // On enregistre le nouveau mot de passe en le hashant
                    $user->setPassword(
                        $passwordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
                    $entityManager->persist($user);
                    $entityManager->flush();
    
                    $this->addFlash('success', 'Mot de passe changé avec succès');
                    return $this->redirectToRoute('app_login');
                }
    
                return $this->render('security/resetpassword.html.twig', [
                    'passForm' => $form
                ]);
            }
            
            // Si le token est invalide on redirige vers le login
            $this->addFlash('danger', 'Jeton invalide');
            return $this->redirectToRoute('app_login');
        }
    }
    
>>>>>>> 47fc7db303b2ed08ae866021ea1dbb90f76e3e71
}
