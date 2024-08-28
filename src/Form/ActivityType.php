<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Activity;
class ActivityType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('NomH', TextType::class,[
                'label'=>'Nom pour l\'homme',
                'attr'=>[                    
                    'Placeholder'=> 'Nom d\'homme',
                    'class'=>'form-control'
                ]

            ])
            ->add('NomF', TextType::class,[
                'label'=>'Nom pour la femme',
                'attr'=>[                    
                    'Placeholder'=> 'Nom de la Femme',
                    'class'=>'form-control'
                ]

            ] 
                )
            ->add('DateCeremonie', TextType::class,[
                    'attr'=>[                                            
                        'Placeholder'=> 'Date de la cérémonie',
                        'class'=>'form-control datepicker',
                        
                    ]
    
                ] 
                    )
            ->add('LieuxCeremonie', TextType::class,[
                        'attr'=>[                    
                            'Placeholder'=> 'Lieux de la cérémonie',
                            'class'=>'form-control'
                        ]
        
                    ] 
                        )
            ->add('LieuxDeReception', TextType::class,[
                            'attr'=>[                    
                                'Placeholder'=> 'Lieux de reception',
                                'class'=>'form-control'
                            ]
            
                        ] 
                            )
            ->add('BudgetInitial', TextType::class,[
                'label'=>'png',
                                'attr'=>[                    
                                'Placeholder'=> 'Lieux de reception',
                                'class'=>'form-control',                                
                                ]
                
                            ] 
        )
        ->add('PhotoPrincipal', FileType::class,[
            'data_class'=>null,
            'label'=>'Photo Principale',
            'attr'=>[                    
            'Placeholder'=> 'Photo Principale',
            'class'=>'form-control',  
            'accept' =>'.jpeg, .png, .jpg, .webp'                             
            ]

        ])
        ->add('PhotoReception', FileType::class,[
            'data_class'=>null,
            'label'=>'Photo de Reception',
            'attr'=>[                    
            'Placeholder'=> 'Photo de reception',
            'class'=>'form-control',  
            'accept' =>'.jpeg, .png, .jpg, .webp'                             
            ]

        ])
        ->add('PhotoCeremonie', FileType::class,[
            'data_class'=>null,
            'label'=>'Photo de Ceremonie',
            'attr'=>[                    
            'Placeholder'=> 'Ceremonie',
            'class'=>'form-control',  
            'accept' =>'.jpeg, .png, .jpg, .webp'
            ]

        ])

        ->add('FichierCsv', FileType::class,[
            'data_class'=>null,
            'label'=>'Fichier pour les listes des invités',
            'attr'=>[                    
            'Placeholder'=> 'rakoto_12.csv',            
            'class'=>'form-control', 
            'accept'=>'.csv'
            ]

        ])
        
        ;           
    }   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}

?>