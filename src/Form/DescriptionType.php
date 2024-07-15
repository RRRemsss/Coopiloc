<?php

namespace App\Form;

use App\Entity\Description;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('area')
            ->add('numberOfRooms')
            ->add('numberOfBedrooms')
            ->add('constructionDate', null, [
                'widget' => 'single_text',
            ])
            ->add('numberOfBathrooms')
            ->add('propertyType')
            ->add('legalRegime')
            ->add('furnished')
            ->add('parking')
            ->add('dependency')
            ->add('cellarType')
            ->add('buildingLot')
            ->add('thousandths')
            ->add('equipment')
            ->add('comment')
            ->add('privateComment')
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Description::class,
        ]);
    }
}
