<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $colors = [
            'Rouge' => '#FF0000',
            'Vert foncé' => '#226D68',
            'Vert clair' => '#2CCED2',
            'Bleu' => '#5784BA',
            'Orange' => '#F27438',
            'Violet' => '#C49FFF',
            'Rose' => '#DB6A8F',
            'Jaune' => '#FFEB69'
        ];

        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Parking' => 'Parking',
                    'Studio' => 'Studio',
                    'Garage' => 'Garage',
                ],
                'multiple' => false,
                'required' => true,
                'label' => false,
                'placeholder' => 'Type de bien',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('namePlace', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nom du bien',
                            'class' => 'form-control'],
            ])
            ->add('color', ChoiceType::class, [
                'label' => false,
                'choices' => array_merge(['' => ''], $colors),
                'choice_label' => function ($choice, $key, $value) use ($colors) {
                    if ($choice === '') {
                        return 'Choix couleur';  // Placeholder text
                    }
                    return $key;
                },
                'required' => false,
                'choice_attr' => function ($choice, $key, $value) {
                    if ($choice === '') {
                        return [];
                    }
                    return ['style' => sprintf('background-color: %s;', $value)];
                },
                'placeholder' => 'Couleur',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('acquisitionDate', DateType::class, [
                'label' => 'Date d\'acquisition',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('acquisitionPrice', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Prix d\'acquisition'],
            ])
            ->add('acquisitionFee', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Frais d\'acquisition'],
            ])
            ->add('agencyFee', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Frais d\'agence'],
            ])
            ->add('propertyValue', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Valeur actuelle'],
            ])

            ->add('address', AddressType::class, [
                'label' => false,
            ])
            ->add('descriptions', CollectionType::class, [
                'entry_type' => DescriptionType::class,
                'label' => false,
            ])
            ->add('rentals', CollectionType::class, [
                'entry_type' => RentalType::class,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
