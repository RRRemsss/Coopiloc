<?php

namespace App\Form;

use App\Entity\leaseParty;
use App\Entity\Property;
use App\Entity\Rental;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('rentalType')
            ->add('grossRent')
            ->add('charge')
            ->add('deposit')
            ->add('lease')
            ->add('netRent')
            ->add('reference')
            ->add('purposeUse')
            ->add('duration')
            ->add('paymentPeriod')
            ->add('paymentMethod')
            ->add('paymentDate')
            ->add('privateComment')
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'id',
            ])
            ->add('leaseParties', EntityType::class, [
                'class' => leaseParty::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
