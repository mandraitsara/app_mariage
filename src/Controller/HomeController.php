<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\UserLogin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home.plan_mariage')]
    public function home(Request $request,EntityManagerInterface $em)
    {
        $templates = 'home.html.twig';      
        $maries = $em->getRepository(Activity::class)->findAll();        
        $content = [
            'maries'=>$maries
        ];
        return $this->render($templates,$content);
    }
}
