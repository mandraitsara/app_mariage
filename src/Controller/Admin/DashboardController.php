<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Categorie;
use App\Entity\UserLogin;
use App\Entity\Prestataire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin/CRUD/', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mariage - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', UserLogin::class);
        yield MenuItem::linkToCrud('Prestataire', 'fa fa-suitcase', Prestataire::class);
        yield MenuItem::linkToCrud('Type', 'fa fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Contacts', 'fa fa-address-book', Contact::class);
    }
}
