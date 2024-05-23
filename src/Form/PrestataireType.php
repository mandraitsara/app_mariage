<?php 
namespace App\Form;

use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PrestataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomPrestataire', TextType::class, 
            [
                'label' => 'Nom du Prestataire', 
                'attr' => [
                    'placeholder'=>'Nom du prestataire ',
                    'class'=>'form-control']
            ])
            ->add('TypePrestataire', TextType::class, [
                'label' => 'Type du Prestataire',
                'attr' => [
                    'placeholder'=>'Type du prestataire ',
                    'class'=>'form-control']
                
               
            ])
            ->add('infoPrestataire', TextType::class, [
                'label'=> 'Info du prestataire',
                'attr' => [
                    'placeholder'=>'Info du prestataire ',
                    'class'=>'form-control']
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestataire::class,
        ]);
    }
}
