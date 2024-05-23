<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ComptePrincipaleController extends AbstractController
{
    #[Route('comptePrincipale/', name:'app_compte_principale')]
    public function comptePrincipale(AuthenticationUtils $authenticationUtils)
    {
        $templates = 'compte_principale.html.twig';

            
            $username =  $authenticationUtils->getLastUsername();
            if ($username==null )            {
                return $this->redirectToRoute('app_login');
            }

            $content = [
                'username' => $username,

            ];
        return $this->render($templates, $content);
    }



}
?>