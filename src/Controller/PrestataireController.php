<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrestataireController extends AbstractController
{
    #[Route('/prestataire', name: 'app_prestataire')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Prestataire::class);
        $prestataires = $repo->findAll();

        return $this->render('prestataire/index.html.twig', [
            'controller_name' => 'PrestataireController',
            'prestataires' => $prestataires
        ]);
    }

    #[Route('/prestataire/new', name: 'app_new')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prestataire = new Prestataire();
        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prestataire);
            $entityManager->flush();

            $this->addFlash('success', 'Prestataire ajouté avec succès.');

            return $this->redirectToRoute('app_prestataire');
        }

        return $this->render('prestataire/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_show')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Prestataire::class);
        $prestataire = $repo->find($id);
        return $this->render('prestataire/show.html.twig', [
            'prestataire' => $prestataire
        ]);
    }
   
}
