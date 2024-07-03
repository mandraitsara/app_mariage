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
        $NomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomH();                             
        $explo = [];

      
        $rowNo = 1;       
//gerer le csv 
        $ext = ".csv";
        $chemin = "info_mariage";
        $fichier = "$chemin/app_mariage_$userID$ext";
        
        if(!file_exists($fichier)){            
            file_put_contents($fichier, "aucun;aucun");
        }elseif(($fp = fopen("$chemin/app_mariage_$userID$ext","r"))){
            while(($row = fgetcsv($fp)) !== FALSE){                              
                for($i = 0; $i < count($row); $i++){
                    $urg =  $row[$i];    
                    $explo[] = $urg;
                    
                }
                
            }          
     
            fclose($fp);
        }
        
    $contenu = $explo;
       $tabs = [];
        for($i=0; $i<count($contenu); $i++)
        {
           $tab = explode(";",$contenu[$i]);
           $tabs[] = $tab;           
                      
        }
        

        $nb_invite = count($tabs);
        $content = [
            'idUser' => $activiteID,
            'nomFemme'=>$NomF,            
            'nomHomme'=>$NomH,            
            'liste_invites' => $tabs,
            'nombre_invite' => $nb_invite,
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
            
         
            
            $project->setNomH($request->request->get('name_epoux'));      
            //$project->setPrenomH($request->request->get('lastname_epoux'));         
            
            


            $project->setNomF($request->request->get('name_epouse'));
        



         $entityManager->flush(); 

         $data = "La modification a été effectué...";
           

            return $this->json($data);
        }  
        
        return $this->json("rechargement reussi....");
    }


    #[Route('/csv', name:'app.csv')]
    public function csvTelecharger():Response
    {
        $explo = [];

      
        $rowNo = 1;
        //$fp is file pointer to file sample.csv
        $templates = "csvTelecharger.html.twig";

        if(($fp = fopen("sample.csv","r")) !== FALSE)
        {
        
      
        echo "<table>";
            while(($row = fgetcsv($fp)) !== FALSE){
                $num = count($row);           
                
                for($i = 0; $i < count($row); $i++){
                    
                    echo "<tr>";
                    echo "<td>";
                    $urg =  $row[$i];    
                    $explo[] = $urg;
                    
                    //$explo + mb_split(";",$urg);                   
                    echo "</td>";
                    echo "</tr>";
                }
                
            }
            echo "</table>";
     
            fclose($fp);
        }
        
        $contenu = $explo;
       $tabs = [];
        for($i=0; $i<count($contenu); $i++)
        {
           $tab = explode(";",$contenu[$i]);
           $tabs[] = $tab;
                      
        }
        
        var_dump($tabs);
        return $this->render($templates,[
            'contenu'=>$tabs

        ]);
    }


}
