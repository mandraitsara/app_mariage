<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/generator', name: 'app_pdf_generator')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface): Response
    {
        $userID = $userInterface->getId(); 

        $NomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomF();
        //$PrenomF = $entityManager->getRepository(Activity::class)->activityId($userID)->getPrenomFgetPrenomF();
        $NomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getNomH();
       // $PrenomH = $entityManager->getRepository(Activity::class)->activityId($userID)->getPrenomH();
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

        $title = 'Informations pour les invité(e)s ';
        $data = [
            'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/profile.svg'),
            'nom_epoux'         => $NomH,
            'nom_epouse'        => $NomF,
            'famille_homme'     => $amis_homme,
            'famille_femme'     => $amis_femme,
            'garcon_dhonneur'   => $garcon_dhonneur,
            'fille_dhonneur'    => $fille_dhonneur,
            'parent_homme'      => $parent_homme,
            'parent_femme'      => $parent_femme,
            'ami_h'             => $ami_h,
            'ami_f'             => $ami_f,
            'titre3'             =>$title,
        ];

        $html =  $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64($path) {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    
}
