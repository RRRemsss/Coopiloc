<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Guarantor;
use App\Entity\IdentityDocument;
use App\Entity\PersonDetail;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuarantorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color')
            ->add('guarantorType')
            ->add('civility')
            ->add('dateOfBirth', null, [
                'widget' => 'single_text',
            ])
            ->add('placeOfBirth')
            ->add('nationality')
            ->add('profession')
            ->add('monthlyIncome')
            ->add('privateComment')
            ->add('guarantorCompanyName')
            ->add('tenant', EntityType::class, [
                'class' => Tenant::class,
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
            ->add('identityDocument', EntityType::class, [
                'class' => IdentityDocument::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guarantor::class,
        ]);
    }
}
