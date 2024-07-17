<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\identityDocument;
use App\Entity\LeaseParty;
use App\Entity\personDetail;
use App\Entity\Rental;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeasePartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color')
            ->add('leasePartyType')
            ->add('civility')
            ->add('dateOfBirth', null, [
                'widget' => 'single_text',
            ])
            ->add('placeOfBirth')
            ->add('profession')
            ->add('monthlyIncome')
            ->add('rentals', EntityType::class, [
                'class' => Rental::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('identityDocuments', EntityType::class, [
                'class' => IdentityDocument::class,
                'choice_label' => 'id',
            ])
            ->add('address', EntityType::class, [
                'class' => Address::class,
                'choice_label' => 'id',
            ])
            ->add('personDetail', EntityType::class, [
                'class' => PersonDetail::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LeaseParty::class,
        ]);
    }
}
