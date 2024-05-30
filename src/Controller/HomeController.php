<?php

namespace App\Controller;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class HomeController extends AbstractController
{

    #[Route('/', name:'home.plan_mariage')]
    public function home(Request $request)
    {
        $templates = 'home.html.twig';
        return $this->render($templates);
    }


    #[Route('who/', name:'app.who')]
    public function who(AuthenticationUtils $authenticationUtils,UserInterface $userInterface,EntityManagerInterface $entityManager)
    {
        
        $user_id = $userInterface->getId();       
        $username =  $authenticationUtils->getLastUsername();        
        $activity = $entityManager->getRepository(Activity::class);
        $activite = $activity->activityId($user_id)->getUser();
        $is_activated = $activite->getId();

        $templates = 'who.html.twig';
        return $this->render($templates);
    }

    
}


?>