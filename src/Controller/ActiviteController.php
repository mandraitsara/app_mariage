<?php 
namespace App\Controller;
use App\Entity\Activity;
use App\Form\ActivityType;
use App\Entity\Prestataire;
use App\Entity\PrestataireTarif;
use App\Entity\PrestataireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;



class ActiviteController extends AbstractController{
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
        $csv = $entityManager->getRepository(Activity::class)->activityId($userID)->getFichierCsv();                
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
        $fichier = "uploads/images/".$csv;       
        if($csv){            
            if (!file_exists($fichier)) {
                file_put_contents($fichier, "non renseigné;non renseigné");
            } elseif (($fp = fopen("$fichier", "r"))) {
                while (($row = fgetcsv($fp)) !== FALSE) {
                    for ($i = 0; $i < count($row); $i++) {
                        $urg =  $row[$i];
                        $explo[] = $urg;
                    }
                }
                fclose($fp);
            }

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
    #[Route('activity_info/{id}',name:'activity.app_mariage')]
    public function infoActivity($id, Request $request, EntityManagerInterface $em)     
    {
       $templates = 'infoActivity.html.twig'; //Template       

       $activite= $em->getRepository(Activity::class)->find($id);

       $photo_principal = $activite->getPhotoPrincipal();
       $photo_reception = $activite->getPhotoReception();
       $photo_ceremonie = $activite->getPhotoCeremonie();

       if (!$activite){
           throw $this->createNotFoundException('aucun prestataire trouvé ' . $id);       }

       $form = $this->createForm(ActivityType::class, $activite);
       
       $form->handleRequest($request);

       if ($form->isSubmitted()){
         /* $photoreception = pathinfo($form->get('PhotoReception')
                                           ->getData()
                                           ->getClientOriginalName()
                                           ,PATHINFO_FILENAME) ;*/

           $photo_principal = $form->get('PhotoPrincipal')->getData();
           $photoreception = $form->get('PhotoReception')->getData();
           $photo_ceremonie = $form->get('PhotoCeremonie')->getData();
           $fichier_csv = $form->get('FichierCsv')->getData();
           if($photoreception && $photo_principal && $photo_ceremonie && $fichier_csv){
               $originalFilename_photoreception = pathinfo($photoreception->getClientOriginalName(), PATHINFO_FILENAME);                
               $originalFilename_photo_principal = pathinfo($photo_principal->getClientOriginalName(), PATHINFO_FILENAME);                
               $originalFilename_photo_ceremonie = pathinfo($photo_ceremonie->getClientOriginalName(), PATHINFO_FILENAME);                
               $originalFilename_fichier_csv = pathinfo($fichier_csv->getClientOriginalName(), PATHINFO_FILENAME);                
               $newFilename_originalFilename_photoreception = uniqid() . '.' . $photoreception->guessExtension();
               $newFilename_originalFilename_photo_principal = uniqid() . '.' . $photo_principal->guessExtension();
               $newFilename_originalFilename_photo_ceremonie = uniqid() . '.' . $photo_ceremonie->guessExtension();
               $newFilename_originalFilename_fichier_csv = uniqid() . '.' . $fichier_csv->guessExtension();

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
               $fichier_csv->move(
                   $this->getParameter('images_directory'),
                   $newFilename_originalFilename_fichier_csv,
               ); 
           }             
           $activite->setPhotoReception($newFilename_originalFilename_photoreception);     
           $activite->setPhotoPrincipal($newFilename_originalFilename_photo_principal);     
           $activite->setPhotoCeremonie($newFilename_originalFilename_photo_ceremonie);
           $activite->setFichierCsv($newFilename_originalFilename_fichier_csv);
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





}


?>