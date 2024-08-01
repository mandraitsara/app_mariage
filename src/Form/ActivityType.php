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
                'attr'=>[                    
                    'Placeholder'=> 'Nom d\'homme',
                    'class'=>'form-control'
                ]

            ])
            ->add('NomF', TextType::class,[
                'attr'=>[                    
                    'Placeholder'=> 'Nom de la Femme',
                    'class'=>'form-control'
                ]

            ] 
                )
            ->add('DateCeremonie', TextType::class,[
                    'attr'=>[                    
                        'Placeholder'=> 'Date de la cérémonie',
                        'class'=>'form-control'
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
                                'attr'=>[                    
                                    'Placeholder'=> 'Lieux de reception',
                                    'class'=>'form-control'
                                ]
                
                            ] 
                                )
            ->add('PhotoPrincipale', FileType::class,[
                            'attr'=>[                    
                                'Placeholder'=> 'Photo de couverture',
                                'class'=>'form-control'
                            ]
            
                        ] 
                            )
            ->add('PhotoCeremonie', FileType::class,[
                                'attr'=>[                    
                                    'Placeholder'=> 'Photo sur Ceremonie',
                                    'class'=>'form-control'
                                ]
                
                            ] 
                                )
            ->add('PhotoReception', FileType::class,[
                                    'attr'=>[                    
                                        'Placeholder'=> 'Photo sur la Reception',
                                        'class'=>'form-control'
                                    ]
                    
                                ] 
                                    );
           
    }   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}

?>