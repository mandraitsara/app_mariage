<?php

namespace App\Form;

use App\Entity\Budget;
use App\Entity\UserLogin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MontantTotal', IntegerType::class, [
                'label' => 'Montant Total',
                'attr' => ['min' => 0],
                'required' => true,
                'empty_data' => '0',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('MontantRestant', IntegerType::class, [
                'label' => 'Montant dépensé',
                'attr' => ['min' => 0],
                'required' => false,
                'empty_data' => '0',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('user_login', EntityType::class, [
                'class' => UserLogin::class,
                'choice_label' => 'id',
                'label' => 'Utilisateur',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
        ]);
    }
}
