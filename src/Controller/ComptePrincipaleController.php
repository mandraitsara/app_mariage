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
    public function activite(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface)
    {
        $templates = 'activity.html.twig';
        $userID = $userInterface->getId();      
//        var_dump($userID)  ;
        $activiteID = $entityManager->getRepository(Activity::class)->activityId($userID)->getId();
        $NomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomF();
        $PrenomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getPrenomF();
        $NomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomH();
        $PrenomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getPrenomH();
        $ami_homme =  $entityManager->getRepository(Activity::class)->activityId($userID)->getAmiProcheH();  
        $ami_femme = $entityManager->getRepository(Activity::class)->activityId($userID)->getAmieProcheF();

        $amis_homme = mb_split(";",$ami_homme);
        $amis_femme = mb_split(";",$ami_femme);

        var_dump($amis_femme);

        $content = [
            'idUser' => $activiteID,
            'nomFemme'=>$NomF,
            'prenomFemme'=>$PrenomF,
            'nomHomme'=>$NomH,
            'prenomHomme'=>$PrenomH,
            'amis_homme' =>$amis_homme,
            'amis_femme' =>$amis_femme,
        ];
        return $this->render($templates, $content);
    }

   
    //methods:['POST']
    #[Route('activite/new/{id}', name: 'active_new.app_mariage', methods:['PUT'])]
    public function activiteEdit(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface, int $id)
    {
        $project = $entityManager->getRepository(Activity::class)->find($id);
        
        if($project)
        {
           
            
            $project->setGarconDHonneur($request->request->get('garcon_dhonneur'));                      
           
            /*
            $project->setGarconDHonneur($request->request->get('garcon_dhonneur_epoux'));

            */
            
            $project->setNomH($request->request->get('name_epoux'));      
            $project->setPrenomH($request->request->get('lastname_epoux'));
            $project->setParentH($request->request->get('parents_epoux'));
            
            $project->setAmiProcheH($request->request->get('famille_homme'));
            $project->setAmiH($request->request->get('ami_epoux'));


            $project->setNomF($request->request->get('name_epouse'));
            $project->setPrenomF($request->request->get('lastname_epouse'));
            $project->setFilleDHonneur($request->request->get('fille_dhonneur_epouse'));            
            $project->setParentF($request->request->get('parents_epouse'));
            $project->setAmieF($request->request->get('ami_epouse'));
            $project->setAmieProcheF($request->request->get('famille_femme'));



         $entityManager->flush(); 

         $data = "La modification a été effectué...";
           

            return $this->json($data);
        }  
        
        return $this->json("rechargement reussi....");
    }
}
