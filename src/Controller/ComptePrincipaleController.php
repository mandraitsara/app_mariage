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
use Symfony\Component\Validator\Constraints\Length;

class ComptePrincipaleController extends AbstractController
{
    #[Route('comptePrincipale/', name: 'app_compte_principale')]
    public function comptePrincipale(AuthenticationUtils $authenticationUtils, UserInterface $userInterface, EntityManagerInterface $entityManager)
    {
        global $is_activated, $user_id, $activite;
        $templates = 'compte_principale.html.twig';
        $Id_Name= $userInterface->getId();
        $activity = $entityManager->getRepository(Activity::class)
                    ->activityId($Id_Name);
        $femme = $activity->getNomF();
        $homme = $activity->getNomH();


        $username =  $authenticationUtils->getLastUsername();
            
        if ($username == null){
            return $this->redirectToRoute('app_login');
        } 
        
        $content = [
            'username' => $username,
            'femme'=>$femme,
            'homme'=>$homme,
        ];
        return $this->render($templates,$content);
    }

    #[Route('activite/', name: "activite.app_mariage")]
    public function activite(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface)
    {
        $templates = 'activity.html.twig';
        $userID = $userInterface->getId();

        $activiteID = $entityManager->getRepository(Activity::class)->activityId($userID)->getId();
        $NomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomF();
        $PrenomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getPrenomF();
        $NomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomH();
        $PrenomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getPrenomH();
        $famille_homme =  $entityManager->getRepository(Activity::class)->activityId($userID)->getAmiProcheH();  
        $famille_femme = $entityManager->getRepository(Activity::class)->activityId($userID)->getAmieProcheF();

        $ami_homme = $entityManager->getRepository(Activity::class)->activityId($userID)->getAmiH();  
        $ami_femme = $entityManager->getRepository(Activity::class)->activityId($userID)->getAmieF();  

        $garcon = $entityManager->getRepository(Activity::class)->activityId($userID)->getGarconDHonneur();
        $fille = $entityManager->getRepository(Activity::class)->activityId($userID)->getFilleDHonneur();
        $parentH = $entityManager->getRepository(Activity::class)->activityId($userID)->getParentH();
        $parentF = $entityManager->getRepository(Activity::class)->activityId($userID)->getParentF();        
        
        $amis_homme = mb_split(";",$famille_homme);
        $amis_femme = mb_split(";",$famille_femme);
        $garcon_dhonneur = mb_split(";",$garcon);
        $fille_dhonneur = mb_split(";", $fille);
        $parent_homme = mb_split(";", $parentH);
        $parent_femme = mb_split(";", $parentF);
        $ami_h = mb_split(";", $ami_homme);
        $ami_f = mb_split(";", $ami_femme);

     
        

        $content = [
            'idUser' => $activiteID,
            'nomFemme'=>$NomF,
            'prenomFemme'=>$PrenomF,
            'nomHomme'=>$NomH,
            'prenomHomme'=>$PrenomH,
            'amis_homme' =>$amis_homme,
            'amis_femme' =>$amis_femme,
            'garcon_dhonneur' =>$garcon_dhonneur,
            'fille_dhonneur' => $fille_dhonneur,
            'parent_homme' => $parent_homme,
            'parent_femme' => $parent_femme,
            'ami_homme' => $ami_h,
            'ami_femme' => $ami_f,            
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
            //$project->setPrenomH($request->request->get('lastname_epoux'));
            $project->setParentH($request->request->get('parents_epoux'));
            
            $project->setAmiProcheH($request->request->get('famille_homme'));
            $project->setAmiH($request->request->get('ami_epoux'));


            $project->setNomF($request->request->get('name_epouse'));
           // $project->setPrenomF($request->request->get('lastname_epouse'));
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
