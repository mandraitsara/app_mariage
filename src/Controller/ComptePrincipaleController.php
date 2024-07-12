<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Prestataire;
use App\Entity\PrestataireTarif;
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
        $Id_Name = $userInterface->getId();
        $activity = $entityManager->getRepository(Activity::class)
            ->activityId($Id_Name);
        $femme = $activity->getNomF();
        $homme = $activity->getNomH();


        $username =  $authenticationUtils->getLastUsername();

        if ($username == null) {
            return $this->redirectToRoute('app_login');
        }

        $content = [
            'username' => $username,
            'femme' => $femme,
            'homme' => $homme,
        ];
        return $this->render($templates, $content);
    }

   
    
    #[Route('activite/', name: "activite.app_mariage")]
    public function activite(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface)
    {
        $templates = 'activity.html.twig';
        $userID = $userInterface->getId();

        $activiteID = $entityManager->getRepository(Activity::class)->activityId($userID)->getId();
        $NomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomF();
        $NomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomH();
        $dateCeremonie = $entityManager->getRepository(Activity::class)->activityId($userID)->getDateCeremonie();
        $lieuCeremonie = $entityManager->getRepository(Activity::class)->activityId($userID)->getLieuxCeremonie();
        $budgetInitial = $entityManager->getRepository(Activity::class)->activityId($userID)->getBudgetInitial();
       
        $presta = $entityManager->getRepository(PrestataireTarif::class)->findAll();
       
        $prestataire[] = $presta;
        var_dump($presta);
        

        
        
        function NbJours($debut, $fin) {

            $tDeb = explode("-", $debut);
            $tFin = explode("-", $fin);
    
             $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
            
        return(($diff / 86400)+0);
    
        }
        global $jourJ;
        if($dateCeremonie!=""){
            $date = $dateCeremonie;
            //var_dump($date);
            $aujourdhui = date('Y-m-d');
            $jourJ = NbJours($date, $aujourdhui);
        }
        

        

        $explo = [];
                
        $rowNo = 1;
        //gerer le csv 
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
            'prestataire' => $presta,
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

        var_dump($tabs);
        return $this->render($templates, [
            'contenu' => $tabs

        ]);
    }
}
