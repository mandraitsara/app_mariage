<?php
namespace App\Controller;

use Exception;
use App\Entity\Activity;
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

class PrestataireController extends AbstractController{
    #[Route('prestataire/budget/{id}', name:"app_budget_prestataire")]
    public function budgetPrestataire(UserInterface $userInterface, EntityManagerInterface $em, $id):Response{
        global $totalPrice;
        $fournisseur = $em->getRepository(Prestataire::class)->find($id);   
        $prestateur = $em->getRepository(PrestataireTarif::class)->prestateurID($id);
        $typePrestateur = $em->getRepository(PrestataireType::class)->findAll();
        $id_activity = $em->getRepository(Activity::class)->find($userInterface->getId());
        $id_activite = $id_activity->getId();        
        $price_active = $id_activity->getBudgetInitial();       
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
            'id_active'=> $id_activite,
            'price_active'=>$price_active
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

?>