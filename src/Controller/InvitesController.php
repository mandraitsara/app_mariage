<?php
namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class InvitesController extends AbstractController{
    #[Route('chargerInvites/{id}', name:"invites_app")]
    public function chargerInvites(EntityManagerInterface $em, $id){
        $templates = 'charger_invites.html.twig';
        $activite = $em->getRepository(Activity::class)->find($id);
        $form = $this->createForm(ActivityType::class, $activite);
        
        $content = [
            'form' => $form->createView()
        ];
       return $this->render($templates, $content);
    }

}

?>