<?php
namespace App\Controller;
use App\Entity\Activity;
use App\Entity\UserLogin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ComptePrincipaleController extends AbstractController
{
    #[Route('comptePrincipale/', name:'app_compte_principale')]
    public function comptePrincipale(AuthenticationUtils $authenticationUtils,UserInterface $userInterface,EntityManagerInterface $entityManager)
    {
        global $is_activated,$user_id;

        $templates = 'compte_principale.html.twig';        
        $user_id = $userInterface->getId();     
        $username =  $authenticationUtils->getLastUsername();      
        
        $activity = $entityManager->getRepository(Activity::class);         
        $activite= $activity->activityId($user_id);       
        
        if($activite!=null){
            $activite= $activity->activityId($user_id)->getUser();
            $is_activated = $activite->getId();
            
        }/*
            else{
                $newActive = new Activity();
                $users = new UserLogin();
                $users->getActivities()->add($newActive);
                $new = $newActive->setUser($users);
                var_dump($new);
                $entityManager->persist($new);
                $entityManager->flush();        

                
        }*/

        if ($username==null )            {
                return $this->redirectToRoute('app_login');
        }
        
        

            $content = [
                'username' => $username,
                'is_activated'=>$is_activated,
            
                
                

            ];
        return $this->render($templates, $content);
    }

    #[Route('activite/', name:"activite.app_mariage")]
    public function activite()
    {
        $templates = 'activity.html.twig';
        



        return $this->render($templates);
    }

    //methods:['POST']
    #[Route('activite/new', name:'active_new.app_mariage')]
    public function activiteNew(Request $request, EntityManagerInterface $entityManager)    
    {
        $entityManager->getRepository(Activity::class);

        $activite = new Activity();
       

        
        return $this->json("created new project successfully");

    }

}
?>