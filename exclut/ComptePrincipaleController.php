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