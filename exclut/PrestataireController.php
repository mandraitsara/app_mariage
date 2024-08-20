<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Categorie;
use App\Form\ContactType;
use App\Entity\Fournisseur;
use App\Entity\Prestataire;
use App\Form\CategorieType;
use App\Form\FournisseurType;
use App\Form\InfoContactType;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManager;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrestataireRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
    /////////////////// AJOUT DE DONNEE///////////////////////
    #[Route('/prestataire/new', name: 'prestataire_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $prestataire = new Prestataire();
        $form = $this->createForm(PrestataireType::class, $prestataire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($prestataire);
            $em->flush();

            return $this->redirectToRoute('prestataire_index');
        }

        return $this->render('prestataire/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /////////// LECTURE DE DONNEE//////////////
    #[Route('/prestataire_show/{id}', name: 'app_show')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Prestataire::class);
        $prestataire = $repo->find($id);
        return $this->render('prestataire/prestataire_show.html.twig', [
            'prestataire' => $prestataire
        ]);
    }
    ///////////MODIFICATION///////////////
    #[Route('/prestataire/edit/{id}', name: 'app_edit')]
    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $prestataire = $entityManager->getRepository(Prestataire::class)->find($id);        
        if (!$prestataire) {
            throw $this->createNotFoundException('Aucun prestataire trouvé ' . $id);
        }

        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Prestataire modifié avec succès.');

            return $this->redirectToRoute('app_prestataire_list');
        }

        $prestataires = $entityManager->getRepository(Prestataire::class)->findAll();

        return $this->render('prestataire/edit.html.twig', [
            'form' => $form->createView(),
            'prestataires' => $prestataires,
        ]);
    }
    //////////////// SUPPRESSION DE DONNEE/////////////////////
    #[Route('/prestataire/delete/{id}', name: 'app_delete')]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $prestataire = $entityManager->getRepository(Prestataire::class)->find($id);
        if (!$prestataire) {
            throw $this->createNotFoundException('Aucun prestataire trouvé ' . $id);
        }

        $entityManager->remove($prestataire);
        $entityManager->flush();

        $this->addFlash('success', 'Prestataire supprimé avec succès.');

        return $this->redirectToRoute('app_prestataire_list');
    }
    ///////////// LISTE ZAVATRA REETRA ///////////
    #[Route('/prestataires', name: 'app_prestataire_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $prestataires = $entityManager->getRepository(Prestataire::class)->findAll();

        return $this->render('prestataire/liste.html.twig', [
            'prestataires' => $prestataires
        ]);
    }

    ///////////// AJOUT CONTACT//////////////
    #[Route('/contact/new', name: 'app_new_contact')]
    public function create_contact(Request $request, EntityManagerInterface $entityManager)
    {
        $contact = new Contact();
        $form = $this->createForm(InfoContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Contact créé avec succès.');

            return $this->redirectToRoute('app_new_contact');
        }
        return $this->render('Contact/createcontact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /////// LISTE CONTACT DISPO /////////
    #[Route('/contacts', name: 'app_contact_list')]
    public function list_contact(EntityManagerInterface $entityManager): Response
    {
        $contacts = $entityManager->getRepository(Contact::class)->findAll();

        return $this->render('Contact/listecontact.html.twig', [
            'contacts' => $contacts
        ]);
    }

    ////// AJOUT CATEGORIE //////////////

    #[Route('/categ/new', name: 'app_categ_new')]
    public function ajout_categ(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès.');

            return $this->redirectToRoute('app_categ_new');
        }

        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        return $this->render('Categorie/creationcateg.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    //////////// LISTE CATEGORIE ////////////
    #[Route('/categ', name: 'app_categ_list')]
    public function list_categ(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(categorie::class)->findAll();

        return $this->render('Categorie/listecateg.html.twig', [
            'categories' => $categories
        ]);
    }
    //////////////////////// AJOUT FOURNISSEUR ///////////////////////////////
    #[Route('/fournisseur/new', name: 'app_fournisseur_new')]
    public function ajout_fournisseur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fournisseur = new FournisseurType();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        /* $categories = $entityManager->getRepository(Categorie::class)->findAll();

        foreach ($categories as $value) {
            var_dump($value) ;
        }*/

        if ($form->isSubmitted()) {
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            $this->addFlash('success', 'Fournisseur OK.');

            return $this->redirectToRoute('app_fournisseur_new');
        }

        $fournisseurs = $entityManager->getRepository(Categorie::class)->findAll();
        return $this->render('Fournisseur/createFourrnisseur.html.twig', [
            'form' => $form->createView(),
            'fournisseurs' => $fournisseurs,
        ]);
    }
    ///////////// LISTE FOURNISSEUR ////////////
    #[Route('/fournisseur', name: 'app_fournisseur_list')]
    public function list_fournisseur(EntityManagerInterface $entityManager): Response
    {
        $fournisseurs = $entityManager->getRepository(FournisseurType::class)->findAll();

        return $this->render('Fournisseur/listefournisseur.html.twig', [
            'fournisseurs' => $fournisseurs
        ]);
    }


    



}
