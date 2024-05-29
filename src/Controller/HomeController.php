<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function who()
    {
        
        $templates = 'who.html.twig';
        return $this->render($templates);
    }

    
}


?>