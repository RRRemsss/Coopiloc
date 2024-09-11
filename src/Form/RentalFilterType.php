<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Rental;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'namePlace',
                'placeholder' => 'Tous les biens',
                'required' => false,
                'label' => 'Filtrer par bien',
                'attr' => ['id' => 'filter-property',
                            'class' => 'form-select'],
            ])

            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Tous' => null,
                    'En retard' => 'late',
                    'Payé' => 'paid',
                    'Payé partiellement' => 'partiallyPaid',
                    'Perdu' => 'lost',
                    'Non payé'=> 'NotYetPaid'
                ],
                'label' => 'Filtrer par statut',
                'required' => false,
                'attr' => ['id' => 'filter-status',
                            'class' => 'form-select']
            ])
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}
