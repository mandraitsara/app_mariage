<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Prestataire;
use App\Entity\UserLogin;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle(' Mariage - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', UserLogin::class);
        yield MenuItem::linkToCrud('Prestataire', 'fa-solid fa-right-to-bracket', Prestataire::class);
        yield MenuItem::linkToCrud('Catégorie', 'fa-solid fa-timeline-arrow', Categorie::class);
        yield MenuItem::linkToCrud('Contact', 'fa-solid fa-address-book', Contact::class);
    }
}
