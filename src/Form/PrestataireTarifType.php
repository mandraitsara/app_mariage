<?php
namespace App\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use App\Entity\PrestataireTarif as Prestataire;
use Proxies\__CG__\App\Entity\PrestataireTarif;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PrestataireTarifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $b, array $options ): void
    {
        $b 
          ->add('PrestaId', IntegerType::class,
        [
            'attr'=>[        
                'hidden' => True,
                'class'=>'form-control hidden_app'
            ]
        ])  
         ->add('TypeId', ChoiceType::class,
            [
                'choices'=> [
                    'Lieu de réception et salle de réception'=>1,
                    'Repas'=>2,
                    'Photo & Vidéo'=>3,
                    'Transport'=>4,
                    'Fleurs et décoration'=>5,
                    'Animation'=>6,
                    'Mise en beauté'=>7,
                    'Tenue vestimentaire'=>8,
                    
                ],
                'label'=>'Categorie',
                'attr'=>[                        
                    'class'=>'form-control hidden_app'
            ]
        ])     
        
        ->add('Prix', TextType::class,
        [
            'attr'=>[        
                
                'class'=>'form-control'
        ]
    ])  
        ->add('Description', TextareaType::class,
        [
            'attr'=>[                        
                'class'=>'form-control'
        ]
    ]) 
        ->add('Photo', FileType::class,
        [
            'data_class'=>null,
            'attr'=>['class'=>'form-control', 'accept'=>'.jpeg, .jpg, .png']
    ]) 
    
                
                ;
    }


public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => PrestataireTarif::class,
        ]);
    }

}


?>