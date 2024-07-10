<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PrestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'Description : '
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact du prestataire : '
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse : '
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du prestataire : '
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom du Prestataire'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
