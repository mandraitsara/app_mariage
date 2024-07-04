<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Categorie;
use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PrestataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomPrestataire', TextType::class, [
                'label' => 'Nom du Prestataire'
            ])
            ->add('TypePrestataire', TextType::class, [
                'label' => 'Type de Prestataire'
            ])
            ->add('infoPrestataire', TextType::class, [
                'label' => 'Information sur le Prestataire'
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'name',
                'label' => 'Contact'
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestataire::class,
        ]);
    }
}
