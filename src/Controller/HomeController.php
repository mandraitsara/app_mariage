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
        //Recuperer la valeur dans l'activité.
      
        $maries = $em->getRepository(Activity::class)->findAll();       
        

        //Fin

        $content = [            
            'maries'=>$maries
        ];
        return $this->render($templates,$content);
    }


    #[Route('who/', name: 'app.who')]
    public function who(AuthenticationUtils $authenticationUtils, UserInterface $userInterface, EntityManagerInterface $entityManager)
    {
        $user_id = $userInterface->getId();
        $username =  $authenticationUtils->getLastUsername();
        $activity = $entityManager->getRepository(Activity::class);

        if($user_id != "null" ){
            return $this->redirectToRoute('activite.app_mariage');
        }
        //$activite = $activity->activityId($user_id)->getUser();
        //$is_activated = $activite->getId();

        $templates = 'who.html.twig';
        return $this->render($templates);
    }


//Chercher l'invité s'il est écrit dans la liste des invités.
#[Route('/searchCsv/{id}', name:'app_search_mariage')]
public function SearchCsv(Request $request,$id,EntityManagerInterface $em)
{
$id_activity = $em->getRepository(UserLogin::class)->find($id)->getId();
$trouver = true;

global $i,$affiche,$nom;

function afficher()                                                 {
    echo 'test';
}

$templates = 'invitesConfirmation.html.twig';

    $f = fopen("info_mariage/app_mariage_12.csv", "r");     
    $nom = $request->request->get('search');
    
    if($f){
        while($ligne=fgets($f))
                    {
                        $l=explode(';',$ligne);
                            $recherche=$l[1];
                            //echo $prenom."=".$recherche."<br>";
                            if($nom==$recherche)
                            {
                                echo '<div class="container"><a href=""><span class="sign_retour">&#8592;</span></a>   <h2>Information pour l\'invité:</h2>';
                                echo '</div>';
                                echo '<div class="row">'    ;
                                echo '<div class="col-md-6 mt-5">';
                                echo '<form action="/searchCsv/'.$id_activity.'" method="POST" class="form-control">';
                                echo '<div class="input-group mb-3">';
                                echo '<div class="input-group-prepend">';
                                echo '<span class="input-group-text" id="basic-addon1">Saisissez votre nom, s\'il vous plaît:</span>';
                                echo '</div>';
                                echo '<input type="text" id="app_search" class="form-control" name="search" id="app_search"aria-describedby="basic-addon1">';                
                                echo '</div>';
                                echo '<button type="submit" class="form-control btn btn-secondary mt-2" id="btn-valider" >valider</button>';
                                echo '</form>   ';
                                echo '</div>';
                                echo '<div class="col-md-6 mt-5">';
                                echo '<div class="affiche"><table class="table"><thead class="thead-dark"><tr><th scope="col" >Nom</th><th scope="col">Prenom</th><th scope="col">Telephone</th><th scope="col">status</th></tr></thead>';
                                echo '<tr><td>'.$l[0].'</td><td>'.$l[1].'</td><td>'.$l[2].'</td><td>'.$l[3].'</td><td><input onclick="';
                                afficher();
                                echo '"name="verif" value="1" type="radio"><span>Oui</span><input name="verif" value="0" type="radio"><span>Non</span></td></tr>';
                                echo '</div>';
                                echo '</table>';
                                echo '</div>';
                                echo '</div>';                               
                                
                                    

                                $trouver=false;
                                
                            }
                    }
                    if($trouver)
                    {
                        echo '<div class="container"><a href=""><span class="sign_retour">&#8592;</span></a>   <h2>Information pour l\'invité:</h2>';
                                echo '</div>';
                                echo '<div class="row">'    ;
                                echo '<div class="col-md-6 mt-5">';
                                echo '<form action="/searchCsv/'.$id_activity.'" method="POST" class="form-control">';
                                echo '<div class="input-group mb-3">';
                                echo '<div class="input-group-prepend">';
                                echo '<span class="input-group-text" id="basic-addon1">Saisissez votre nom, s\'il vous plaît:</span>';
                                echo '</div>';
                                echo '<input type="text" id="app_search" class="form-control" name="search" id="app_search"aria-describedby="basic-addon1">';                
                                echo '</div>';
                                echo '<button type="submit" class="form-control btn btn-secondary mt-2" id="btn-valider" >valider</button>';
                                echo '</form>   ';
                                echo '</div>';
                                echo '<div class="col-md-6 mt-5">';
                                echo '<div class="affiche"><table class="table"><thead class="thead-dark"><tr><th scope="col" >Nom</th><th scope="col">Prenom</th><th scope="col">Telephone</th><th scope="col">status</th></tr></thead>';
                                echo '<tr><td colspan="4"><span class="text-danger text-center">Vous n\'êtes pas inscrit sur la liste d\'invités<span></td></tr>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                        
                    }
                fclose($f);
                
                }
                
    

    return $this->render($templates);
}

//Fin

#[Route('/csvmodif/', name:'modifcsv')]
public function csvmodif(){
    $filename = "info_mariage/app_mariage_12.csv";
    $lineToModify = 2;
    $newData = ['Nouvelle','Donnee','pour','contre'];
    $rows = [];
    global $dd,$index;
    $ex = [];
    $lignes = 0;
    

    if (($handle = fopen($filename, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $rows[] = $data;        
        $index = 
        var_dump($rows);
        
    }
    fclose($handle);
}


    return new JsonResponse('okkk');
}

}
