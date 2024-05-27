<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre', TextType::class,
            [
                'attr' => [
                    'placeholder' => 'Titre : ',
                    'class' => 'form-control'
                ]
            ])
            ->add('Description', TextareaType::class,
            [
                'attr' => [
                    'placeholder' => 'Description ',
                    'class' => 'form-control'
                ]
            ])
            ->add('TitreCateg', TextType::class,[
                'attr' => [
                    'placeholder' => 'Titre de la catégorie',
                    'class' => 'form-control'
                ]
            ])
            ->add('SousCateg', TextType::class,
            [
                'attr' => [
                    'placeholder'=> 'Sous catégorie : ',
                    'class' => 'form-control'
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
