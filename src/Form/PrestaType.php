<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PrestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label'=>'Nom du prestataire',
            'attr'=>[
                'class'=>'form-control', 
            ]
          
            ])
            ->add('contact', TextType::class, [
          
                'label' => 'Contact du prestataire : ',
                'attr'=>[
                    'class'=>'form-control', 
                ]
            ])
            ->add('adresse', TextType::class, [
               
                'label' => 'Adresse : ',
                'attr'=>[
                    'class'=>'form-control', 
                ]
            ])
            ->add('email', EmailType::class, [
               
                'label' => 'Email du prestataire : '
                ,
                'attr'=>[
                    'class'=>'form-control', 
                ]
            ])
            ->add('description', TextType::class, [
                
                'label' => 'Description : ',
                'attr'=>[
                    'class'=>'form-control', 
                ]
            ])
            ->add('photo', FileType::class,[
                'data_class'=>null,
                'label'=>'Fichier pour le prestataire',
                'attr'=>[                    
                'Placeholder'=> 'image.jpg',            
                'class'=>'form-control', 
                
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
