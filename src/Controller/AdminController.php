<?php
namespace App\Controller;
use App\Entity\UserLogin;
use App\Entity\Prestataire;
use App\Entity\PrestataireTarif;
use App\Entity\PrestataireType;
use App\Form\PrestataireTarifType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Json;

class AdminController extends AbstractController
{
    #[Route('admin/app/', name:'admin_app')]
    public function adminApp(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator){
        $templates = "admin/adminTemplate.html.twig";
        
        try{
            $donnees =  $em->getRepository(Prestataire::class)->findBy([],['populChiffre'=>'desc']); 
            $donneesUser = $em->getRepository(UserLogin::class)->findAll();
            $donneesTypes= $em->getRepository(PrestataireType::class)->findAll();
            $prestataires = $paginator->paginate($donnees, $request->query->getInt('page', 1),10);   
            $user = $paginator->paginate($donneesUser, $request->query->getInt('page', 1), 10);  
            $type = $paginator->paginate($donneesTypes, $request->query->getInt('page', 1), 10);  

        
        }catch(Exception $e){
            echo 'Exception reçue:', $e->getMessage(), "\n";
        }

        $content = [
            'user'=> $user,
            'prestataire'=>$prestataires,
            'type'=>$type
        ];
        return $this->render($templates,$content);
      }



      #[Route('admin/app/edit/{id}', name:'app_edit_app') ]
      public function adminEdit(Request $request , EntityManagerInterface $em,$id){        
        global $presta_id,$message,$photo,$id_type,$type_id,$price_Total;
        $templates = "admin/adminAppEditTemplate.html.twig";
        $prestateur = $em->getRepository(PrestataireTarif::class)->prestateurID($id);     
        
        
        //Detecter si le prestateur n'est pas encore renseigné dans la table PrestataireTarif
        if($prestateur==null){
            $prestateur = $em->getRepository(Prestataire::class)->find($id);
            $presta_id = $prestateur->getId();
            $price_Total = [0];

        }else{
            $price_Total = [];
            $id_prestateur = [];  
            $type_id = []      ;
            foreach($prestateur as $prestateurs){        
                $id_presta = $prestateurs->getPrestaId();
                $id_type = $prestateurs->getTypeId();                
                $type_id[] = $id_type;
                $price = $prestateurs->getPrix();
                $id_prestateur[] = $id_presta;
                $price_Total[] = $price;
            }
            $presta_id = $id_prestateur[0];        
        }
        
       $price_Total = array_sum($price_Total)?array_sum($price_Total):0;      

        $prestatairetype = new PrestataireTarif();
        
        $form = $this->createForm(PrestataireTarifType::class, $prestatairetype);        
        $form->handleRequest($request);

        
        

        if($form->isSubmitted() && $form->isValid()){            
            
            $id_type = $form->get('TypeId')->getData();
         
            $photo = $form->get('Photo')->getData();
            
            if($photo){
                $originalFilename_photo = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); 
                $newFilename_originalFilename_photo = uniqid() . '.' . $photo->guessExtension();               
            }
            $photo->move(
                $this->getParameter('images_directory'),
                $newFilename_originalFilename_photo,
            );
            $prestatairetype->setPhoto($newFilename_originalFilename_photo);
         
            if($type_id==null){
                $em->persist($prestatairetype);            
                $em->flush();    
            }else{
                if(in_array($id_type, $type_id, false)){        
                    $message = "Vous avez déjà utilisé cette categorie ";
                    }else{
                        $em->persist($prestatairetype);            
                        $em->flush();            
            }
        }
    }
        
        $content = [
            'prestateur' => $prestateur,
            'form' => $form->createView(),
            'presta_id' => $presta_id,
            'TotalPrice' =>$price_Total,
            'message'=>$message,
        ];

        
        return $this->render($templates, $content);
      }

      #[Route("budgetPrestataire/{id}", name:'budget_prestataire')]
      public function budgetPrestaire(Request $request, EntityManagerInterface $em, $id)
      {
        $prestataire = $em->getRepository(Prestataire::class)->find($id);
        if($prestataire){
            $prestataire->setBudget($request->request->get("budget"));            
            $em->flush();            
        }
        return $this->json("Opération effectué...");
      }

      #[Route("CategorieDelete/{id}", name:"delete_categorie")]
      public function CategorieDelete($id, EntityManagerInterface $em, Request $request)
      {
        $prestataire = $em->getRepository(PrestataireTarif::class)->find($id);
        if($prestataire){
            $em->remove($prestataire);
            $em->flush();
            echo "<script>alert('Suppression effectuée')</script>";
            return $this->redirectToRoute('admin_app');
        }

        return $this->redirectToRoute('admin_app');
      }
}
?>