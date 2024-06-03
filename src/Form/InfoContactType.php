<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class InfoContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Le nom : ',
                'attr' => [
                    'placeholder' => 'Le gérant',
                    'class' => 'form-control'
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse : ',
                'attr' => [
                    'placeholder' => 'Adresse...',
                    'class' => 'form-control'
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Adresse Email : ',
                'attr' => [
                    'placeholder' => 'Adresse Email',
                    'class' => 'form-control'
                ]
                ]);/*
            ->add('numero', TextType::class, [
                'label' => 'Contact : ',
                'attr' => [
                    'placeholder' => 'Contact',
                    'class' => 'form-control'
                ]
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
