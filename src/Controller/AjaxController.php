<?php

namespace App\Controller;

use App\Entity\Prestataire;
use Doctrine\Persistence\ManagerRegistry; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AjaxController extends AbstractController
{
    #[Route('/ajax/prestataire', name: 'app_ajax_prestataire')]
    public function ajaxAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $prestataires = $entityManager->getRepository(Prestataire::class)->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($prestataires as $prestataire) {
                $temp = array(
                    'NomPrestataire' => $prestataire->getNomPrestataire(),
                    'TypePrestataire' => $prestataire->getTypePrestataire(),
                    'infoPrestataire' => $prestataire->getInfoPrestataire() 
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData); 
        } else {
            return $this->render('ajax/index.html.twig'); 
        }
    }
}
