<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Prestataire;
use App\Entity\PrestataireTarif;
use App\Entity\PrestataireType;
use App\Entity\UserLogin;
use App\Form\ActivityType;
use Doctrine\Migrations\Version\Executor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $Id_Name = $userInterface->getId();
        $activity = $entityManager->getRepository(Activity::class)
            ->activityId($Id_Name);
        $femme = $activity->getNomF();
        $homme = $activity->getNomH();
        $date_at = $activity->getDateAt();

        $username =  $authenticationUtils->getLastUsername();

        if ($username == null) {
            return $this->redirectToRoute('app_login');
        }

        $content = [
            'username' => $username,
            'femme' => $femme,
            'homme' => $homme,
            'date_at'=>$date_at,
        ];
        return $this->render($templates, $content);
    }

   
    
    #[Route('activite/', name: "activite.app_mariage")]
    public function activite(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface)
    {
        global $prestateur,$jourJ,$type,$prestas;
        $templates = 'activity.html.twig'; // Appeler la template via //Template
        //identifier le numero d'User
        $userID = $userInterface->getId();
        //Fin
        $activiteID = $entityManager->getRepository(Activity::class)->activityId($userID)->getId(); //voir l'identité dans l'activité
        $NomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomF(); //Nom pour l'époux
        $NomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomH();//Nom pour l'épouse
        $dateCeremonie = $entityManager->getRepository(Activity::class)->activityId($userID)->getDateCeremonie(); //Date de céremonie 
        $lieuCeremonie = $entityManager->getRepository(Activity::class)->activityId($userID)->getLieuxCeremonie();//Lieux de céremonie 
        $budgetInitial = $entityManager->getRepository(Activity::class)->activityId($userID)->getBudgetInitial(); //Budget initial
        $photo_principal = $entityManager->getRepository(Activity::class)->activityId($userID)->getPhotoPrincipal(); //Photo principal
        $photo_reception = $entityManager->getRepository(Activity::class)->activityId($userID)->getPhotoReception(); //Photo Reception
        $photo_ceremonie = $entityManager->getRepository(Activity::class)->activityId($userID)->getPhotoCeremonie(); //Photo Ceremonie        
        $phoneH = $entityManager->getRepository(Activity::class)->activityId($userID)->getPhoneHomme();
        $phoneF = $entityManager->getRepository(Activity::class)->activityId($userID)->getPhoneFemme();
        
        $prestateurs = $entityManager->getRepository(Prestataire::class)->findBy([],['populChiffre'=>'DESC'],5); 
        
        //Verifier s'il y a déjà commander un package de prestateur
        $idPrestateur = $entityManager->getRepository(Activity::class)->activityId($userID)->getIdPrestateur();
        //fin
        //S'il n'y a pas encore commander
        if ($idPrestateur !== NULL){
            $fournisseur = $entityManager->getRepository(Prestataire::class)->find($idPrestateur);            
            $prestateur = $entityManager->getRepository(PrestataireTarif::class)->prestateurID($fournisseur);
            $typePrestateur = $entityManager->getRepository(PrestataireType::class)->findAll();

        
        $prestas = [];        
        $totalPrice = [];


        foreach($prestateur as $presta){
            $prestateur = [
                'type' => $presta->getTypeId(),
                'price'=>$presta->getPrix(),
                'description'=>$presta->getDescription()
            ];            
            $prestas[] = $prestateur;
            $totalPrice[] = $prestateur['price'];
            $type[] = $prestateur['type'];
            
        }
        
        $PrixTotal = array_sum($totalPrice);
            
        }
        else{
            $fournisseur = 0;
        }
        
        

      
       
        //$prestataire = [];
        //$prestaPrix = [];

       /* $pres = [];
        foreach($presta as $prestas){
               /* $pres = [
                    'prestateur' => $prestas->getPrestataire(),
                   // 'prix' => $prestas->getPrix()
                ];

            $prest[] = $pres;
            $prestataire[] =  $prestas-> ;               
        }       
        */
        //Function pour gerer le jour -j
        function NbJours($debut, $fin) {

            $tDeb = explode("-", $debut);
            $tFin = explode("-", $fin);
    
             $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
            
        return(($diff / 86400)+0);
    }
    
        //fin

        //Detecter si la date de ceremonie n'est pas vide
        if($dateCeremonie!=""){
            $date = $dateCeremonie;            
            $aujourdhui = date('Y-m-d');
            $jourJ = NbJours($date, $aujourdhui);
        }
        //Fin        

        //gerer le csv 
        $explo = [];
                
        $rowNo = 1;
        
        $ext = ".csv";
        $chemin = "info_mariage";
        $fichier = "$chemin/app_mariage_$userID$ext";

        if (!file_exists($fichier)) {
            file_put_contents($fichier, "non renseigné;non renseigné");
        } elseif (($fp = fopen("$chemin/app_mariage_$userID$ext", "r"))) {
            while (($row = fgetcsv($fp)) !== FALSE) {
                for ($i = 0; $i < count($row); $i++) {
                    $urg =  $row[$i];
                    $explo[] = $urg;
                }
            }

            fclose($fp);
        }

        
        $contenu = $explo;
        $tabs = [];
        for ($i = 0; $i < count($contenu); $i++) {
            $tab = explode(";", $contenu[$i]);
            $tabs[] = $tab;
        }

//fin
        //Pour la pagination
        $nb_invite = count($tabs);

        $parPage = 10;
        $Nb_pages = ceil($nb_invite / $parPage);
        $my_huge_array = [];

        $pagination = [            
                'length' => isset($_GET['length']) ? $_GET['length']: 10,
                'total' => sizeof($tabs),
                'currentPage' => isset($_GET['page']) ? $_GET['page'] : 1,
                
        ];

        $pagination['nbPages'] = ceil($pagination['total'] / $pagination['length']) ;
        $pagination['offset'] = ($pagination['currentPage'] * $pagination['length']) -  $pagination['length'] ;
        $paginated = array_slice($tabs, $pagination['offset'], $pagination['length'], true);

        $pageCurrent = $pagination['currentPage']; 
        //Fin   
        
              
        
        $content = [
            'idUser' => $activiteID,
            'nomFemme' => $NomF,
            'nomHomme' => $NomH,
            'liste_invites' => $paginated,
            'nombre_invite' => $nb_invite,
            'dateCeremonie' => $dateCeremonie,
            'lieuxCeremonie' => $lieuCeremonie,
            'jourJ' => $jourJ,
            'nbPages' => $pagination['nbPages'] ,
            'currentPage'=> $pageCurrent,
            'budgetInitial' => $budgetInitial,            
            'pres' => $prestateurs,
            'fournisseur'=>$fournisseur,
            'id'=>$userID,
            'prestateur'=> $prestateur,         
            'photo_principal'=>$photo_principal,
            'photo_reception'=>$photo_reception,
            'photo_ceremonie'=>$photo_ceremonie,
            'phoneH'=>$phoneH,
            'phoneF'=>$phoneF,   
            'id_presta' =>$idPrestateur
        ];
        return $this->render($templates, $content);
    }


    //methods:['POST']
    #[Route('activite/new/{id}', name: 'active_new.app_mariage', methods: ['PUT'])]
    public function activiteEdit(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface, int $id)
    {
        $project = $entityManager->getRepository(Activity::class)->find($id);

        if ($project) {
            $date_at = date('d/m/y;H:i:s');
            $project->setNomH($request->request->get('name_epoux'));
            $project->setNomF($request->request->get('name_epouse'));
            $project->setDateCeremonie($request->request->get('date_ceremonie'));
            $project->setLieuxCeremonie($request->request->get('lieu_ceremonie'));
            $project->setBudgetInitial($request->request->get('budget_initial'));
            $project->setDateAt($date_at);
            $entityManager->flush();
            $data = "La modification a été effectué...";
            return $this->json($data);
        }
        return $this->json("rechargement reussi....");
    }


    #[Route('/csv', name: 'app.csv')]
    public function csvTelecharger(): Response
    {
        $explo = [];


        $rowNo = 1;
        //$fp is file pointer to file sample.csv
        $templates = "csvTelecharger.html.twig";

        if (($fp = fopen("sample.csv", "r")) !== FALSE) {
            echo "<table>";
            while (($row = fgetcsv($fp)) !== FALSE) {
                $num = count($row);

                for ($i = 0; $i < count($row); $i++) {

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
        for ($i = 0; $i < count($contenu); $i++) {
            $tab = explode(";", $contenu[$i]);
            $tabs[] = $tab;
        }
        
        return $this->render($templates, [
            'contenu' => $tabs

        ]);
    }

     #[Route('/csv/open', name: 'app_csv')]
     public function csvCharger(){
       $dirN = '../public/info_mariage/';     
       

      var_dump(opendir($dirN));
       //var_dump(chroot('../public/'));
       
      
       //opendir(is_dir($dirN));
//        $chemin = dirname('../public/info_mariage/app_mariage_12.csv');
   
     
        
        return new JsonResponse('');
     }


     #[Route('activity_info/{id}',name:'activity.app_mariage')]
     public function infoActivity($id, Request $request, EntityManagerInterface $em)     
     {
        $templates = 'infoActivity.html.twig'; //Template       

        $activite= $em->getRepository(Activity::class)->find($id);

        $photo_principal = $activite->getPhotoPrincipal();
        $photo_reception = $activite->getPhotoReception();
        $photo_ceremonie = $activite->getPhotoCeremonie();

        if (!$activite){
            throw $this->createNotFoundException('aucun prestataire trouvé ' . $id);
        }

        $form = $this->createForm(ActivityType::class, $activite);
        //var_dump($form);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
          /* $photoreception = pathinfo($form->get('PhotoReception')
                                            ->getData()
                                            ->getClientOriginalName()
                                            ,PATHINFO_FILENAME) ;*/

            $photo_principal = $form->get('PhotoPrincipal')->getData();
            $photoreception = $form->get('PhotoReception')->getData();
            $photo_ceremonie = $form->get('PhotoCeremonie')->getData();
            if($photoreception && $photo_principal && $photo_ceremonie){
                $originalFilename_photoreception = pathinfo($photoreception->getClientOriginalName(), PATHINFO_FILENAME);                
                $originalFilename_photo_principal = pathinfo($photo_principal->getClientOriginalName(), PATHINFO_FILENAME);                
                $originalFilename_photo_ceremonie = pathinfo($photo_ceremonie->getClientOriginalName(), PATHINFO_FILENAME);                
                $newFilename_originalFilename_photoreception = uniqid() . '.' . $photoreception->guessExtension();
                $newFilename_originalFilename_photo_principal = uniqid() . '.' . $photo_principal->guessExtension();
                $newFilename_originalFilename_photo_ceremonie = uniqid() . '.' . $photo_ceremonie->guessExtension();

                // Déplace le fichier dans le répertoire de destination
                $photoreception->move(
                    $this->getParameter('images_directory'),
                    $newFilename_originalFilename_photoreception,
                ); 
                $photo_principal->move(
                    $this->getParameter('images_directory'),
                    $newFilename_originalFilename_photo_principal,
                ); 
                $photo_ceremonie->move(
                    $this->getParameter('images_directory'),
                    $newFilename_originalFilename_photo_ceremonie,
                ); 
            }             
            $activite->setPhotoReception($newFilename_originalFilename_photoreception);     
            $activite->setPhotoPrincipal($newFilename_originalFilename_photo_principal);     
            $activite->setPhotoCeremonie($newFilename_originalFilename_photo_ceremonie);
            $em->flush();
        }

        $content = [
            'form' => $form->createView(),
            'photo_reception' =>$photo_reception,
            'photo_principal'=>$photo_principal,
            'photo_ceremonie'=>$photo_ceremonie,
        ];
        return $this->render($templates,$content);
    }


    #[Route('fichier/', name:'fichier_txt')]
    public function fichier(){
        //Template 
        $templates = 'fichier_txt.html.twig';

        //chemin vers le fichier 
        $chemin_fichier = file('info_mariage/mon_fichier.txt');

       /*
        $contenu_fichiers = file_get_contents($chemin_fichier);
        
        $contenu = explode(";", $contenu_fichiers);
        var_dump($contenu); exit;
        echo nl2br(htmlspecialchars($contenu));
*/
        //Lire le contenu du fichier
        $contenu_fichier = file($chemin_fichier);

        var_dump($contenu_fichier);

        //spécifier la ligne modifier
        $ligne_a_modifier = 2;

        $nouveau_contenu_ligne = 'zafy;tahiana;tanjona';

        if(isset($contenu_fichier[$ligne_a_modifier])){        
            $contenu_fichier[$ligne_a_modifier] = $nouveau_contenu_ligne .PHP_EOL;

        }
        file_put_contents($chemin_fichier, implode(';', $contenu_fichier));
        
        return $this->render($templates);
    }
}