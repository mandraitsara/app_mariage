<?php

namespace App\Controller\Admin;

use App\Entity\Prestataire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PrestataireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
       
        return Prestataire::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Prestataires')
            ->setEntityLabelInSingular('Prestataire')
            ->setPageTitle('index', 'Administrations de prestataires')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('Nom'),
            TextField::new('Contact'),
            TextField::new('Adresse'),
            TextField::new('Email'),                       
            
            
        ];
    }
}
