<?php
namespace App\Controller;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('admin/', name:'admin_app')]
    public function adminApp(Request $request, EntityManager $em){
        
      }
}
?>