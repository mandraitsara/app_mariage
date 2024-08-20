<?php

namespace App\Controller;

use Exception;
use JsonException;
use App\Entity\Presta;
use App\Entity\Activity;
use App\Form\PrestaType;
use App\Entity\Prestataire;
use App\Entity\PrestataireType;
use App\Entity\PrestataireTarif;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
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

    #[Route('prestataire/gerer', name:'budjet_new', methods:["PUT"])]
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

    public function budgetPrestataire(UserInterface $userInterface, EntityManagerInterface $em, $id):Response{
        global $totalPrice;
        $fournisseur = $em->getRepository(Prestataire::class)->find($id);   
        $prestateur = $em->getRepository(PrestataireTarif::class)->prestateurID($id);
        $typePrestateur = $em->getRepository(PrestataireType::class)->findAll();
        $id_activity = $em->getRepository(Activity::class)->find($userInterface->getId());
        $id_activite = $id_activity->getId();      

        
        
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
            'id_active'=> $id_activite
        ];
        
        $templates = 'prestataire/budgetPrestataire.html.twig';

        return $this->render($templates, $content);
    }

    #[Route('VoirPrestataire/', name:"prestataireComplet")]
    public function prestataireComplet(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator){
        global $listes_des_prestataires;
        try{
            $donnees =  $em->getRepository(Prestataire::class)->findBy([],['populChiffre'=>'desc']); 
            $prestataires = $paginator->paginate(
                $donnees, $request->query->getInt('page', 1),
                6
            );         
            

            
        }catch(Exception $e){
            echo 'Exception reçue:', $e->getMessage(), "\n";
        }

        $content = [
            'listes_des_prestataires' => $prestataires,
        ];
        $templates = "presta/prestataire_affiche.html.twig";
        return $this->render($templates,$content);
    }


    #[Route('panier/{id}', name:"panier_app")]
    public function panier(Request $request, EntityManagerInterface $em,$id){
        $activite = $em->getRepository(Activity::class)->find($id);    
   
        if($activite){
            $activite->setIdPrestateur($request->request->get("id_fournisseur"));            
            $em->flush();
        }
        return $this->json("ajout panier reuissi...");
    }

    #[Route('montant/{id}', name:'montant_app')]
    public function montant(Request $request, EntityManagerInterface $em, $id){
        $activite = $em->getRepository(Activity::class)->find($id);
        if($activite){
            $activite->setBudgetInitial($request->request->get("montant"));            
            $em->flush();
        }
        return $this->json("ajout panier reuissi...");
    }

    #[Route('popularite/{id}', name:'popularite_app')]
    public function popularite(request $request, EntityManagerInterface $em, $id){
        $prestataire = $em->getRepository(Prestataire::class)->find($id);
        if($prestataire){
            $prestataire->setPopulChiffre($request->request->get("popularite"));
            $em->flush();
        }

        return $this->json('ajout code popularite effecuté...');

    }

}
