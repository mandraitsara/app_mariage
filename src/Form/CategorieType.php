<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Categorie;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TitreCategorie', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre catégorie',
                    'class' => 'form-control'
                ]
            ])
            ->add('SoustitreCategorie', TextType::class, [
                'attr' => [
                    'placeholder' => 'Sous-titre de la catégorie',
                    'class' => 'form-control'
                ]
            ])
            ->add('Content', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Commentaire',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
