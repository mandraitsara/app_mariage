<?php

namespace App\Controller;

use App\Entity\Presta;
use App\Form\PrestaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrestaController extends AbstractController
{
    #[Route('/presta', name: 'app_presta')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Presta::class);
        $presta = $repo->findAll();

        return $this->render('presta/index.html.twig', [
            'controller_name' => 'PrestaController',
            'presta' => $presta
        ]);
    }
    #[Route('/presta/new', name: 'presta_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $presta = new Presta();
        $form = $this->createForm(PrestaType::class, $presta);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($presta);
            $em->flush();

            return $this->redirectToRoute('app_show');
        }

        return $this->render('presta/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/show/{id}', name: 'app_show')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Presta::class);
        $presta = $repo->find($id);
        return $this->render('presta/show.html.twig', [
            'presta' => $presta
        ]);
    }
    #[Route('/presta/edit/{id}', name: 'app_edit')]
    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $presta = $entityManager->getRepository(Presta::class)->find($id);
        if (!$presta) {
            throw $this->createNotFoundException('Aucun prestataire trouvé ' . $id);
        }

        $form = $this->createForm(PrestaType::class, $presta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Prestataire modifié avec succès.');

            return $this->redirectToRoute('app_presta_list');
        }

        $prestataires = $entityManager->getRepository(Presta::class)->findAll();

        return $this->render('presta/edit.html.twig', [
            'form' => $form->createView(),
            'prestataires' => $prestataires,
        ]);
    }
    #[Route('/presta/delete/{id}', name: 'app_delete')]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $presta = $entityManager->getRepository(Presta::class)->find($id);
        if (!$presta) {
            throw $this->createNotFoundException('Aucun prestataire trouvé ' . $id);
        }

        $entityManager->remove($presta);
        $entityManager->flush();

        $this->addFlash('success', 'Prestataire supprimé avec succès.');

        return $this->redirectToRoute('app_presta_list');
    }
    ///////////// LISTE ZAVATRA REETRA ///////////
    #[Route('/prestataires', name: 'app_presta_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $prestas = $entityManager->getRepository(Presta::class)->findAll();

        return $this->render('presta/liste.html.twig', [
            'prestas' => $prestas
        ]);
    }
}
