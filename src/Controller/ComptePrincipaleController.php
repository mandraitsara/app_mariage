<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\UserLogin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ComptePrincipaleController extends AbstractController
{
    #[Route('comptePrincipale/', name: 'app_compte_principale')]
    public function comptePrincipale(AuthenticationUtils $authenticationUtils, UserInterface $userInterface, EntityManagerInterface $entityManager)
    {
        global $is_activated, $user_id, $activite;
        $templates = 'compte_principale.html.twig';
        $Id_Name= $userInterface->getId();
        $activity = $entityManager->getRepository(Activity::class)
                    ->activityId($Id_Name)
                    ->getUser()
                    ->getUsername();

        $username =  $authenticationUtils->getLastUsername();
            
        if ($username == null){
            return $this->redirectToRoute('app_login');
        } 
        
        $content = [
            'username' => $username,
            'is_activated' => $activity,
        ];
        return $this->render($templates,$content);
    }

    #[Route('activite/', name: "activite.app_mariage")]
    public function activite()
    {
        $templates = 'activity.html.twig';
        return $this->render($templates);
    }

    //methods:['POST']
    #[Route('activite/new/{id}', name: 'active_new.app_mariage', methods:['PUT'])]
    public function activiteEdit(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface, int $id)
    {
        $project = $entityManager->getRepository(Activity::class)->find($id);
        
        if(!$project){
            return $this->json('No project found for id' . $id, 404);
        }

        $project->setNomF($request->request->get('name_epouse'));        
        $project->setNomH($request->request->get('lastname_epouse'));
        $entityManager->flush();
        $data = [
            'id'=>$project->getId(),
            'name_epouse' => $project->getNomF(),
            'lastname_epouse'=>$project->getNomH()
        ];

        

        return $this->json($data);
    }
}
