<?php

namespace App\Controller;

use App\Entity\Presta;
use App\Entity\Prestataire;
use App\Entity\PrestataireTarif;
use App\Entity\PrestataireType;
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

    #[Route('prestataire/budget/new', name:'budjet_new', methods:["PUT"])]
    public function addBudget(Request $request, EntityManagerInterface $em){

        $tarifs = new PrestataireTarif();
        $id_prestataire = new Prestataire();
        $id_typeprestataire = new PrestataireType();
        
        //$tarifs->setPrestataire();
        //$tarifs->setPrestaType($id_typeprestataire->getId($request->request->get('id_type')));
        $id = isset($_POST['id_prestateur'])? null : '2';
        //$tarifs->setPrestataire($id_prestataire->setId($id));
        $tarifs->setDescription($request->request->get('description'));
        $tarifs->setPrix($request->request->get('price'));      
        $em->persist($tarifs);
        $em->flush();

        return $this->json("Created new project successfully...");
    }


    #[Route('prestataire/budget/{id}', name:"app_budget_prestataire")]

    public function budgetPrestataire(EntityManagerInterface $em, $id):Response{
        global $totalPrice;     
        $fournisseur = $em->getRepository(Prestataire::class)->find($id);       
        $prestateur = $em->getRepository(PrestataireTarif::class)->prestateurID($id);
        $typePrestateur = $em->getRepository(PrestataireType::class)->findAll();

        
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
        
       
        $content = [
            'typePrestateur' => $typePrestateur,
            'prestateur' => $prestas,
            'totalPrice' => $PrixTotal,
            'id_prestateur' => $id,
            'fournisseur'   =>$fournisseur,
        ];
        
        $templates = 'prestataire/budgetPrestataire.html.twig';

        return $this->render($templates, $content);
    }
}
