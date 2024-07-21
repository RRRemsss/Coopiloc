<?php

namespace App\Form;

use App\Entity\Description;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //ConstructionDate setting
        $currentYear = date('Y');
        $years = range($currentYear - 125, $currentYear);
        
        $builder
            ->add('area', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Surface',
                            'class' => 'form-control'],
            ])
            ->add('numberOfRooms', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => range(1, 20),
                'choice_label' => function($choice, $key, $value) {
                    return $value;
                },
                'placeholder' => 'Nombre de pièces',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('numberOfBedrooms', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => range(1, 20),
                'choice_label' => function($choice, $key, $value) {
                    return $value;
                },
                'placeholder' => 'Nombre de chambres',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('numberOfBathrooms', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => range(1, 10),
                'choice_label' => function($choice, $key, $value) {
                    return $value;
                },
                'placeholder' => 'Nombre de salles de bain',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('numberOfShower', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => range(1, 10),
                'choice_label' => function($choice, $key, $value) {
                    return $value;
                },
                'placeholder' => 'Nombre de salle d\'eau',
                'attr' => ['class' => 'form-select form-select-ms mb-'],
            ])
            ->add('constructionDate', ChoiceType::class, [
                'label' => false,
                'choices' => array_combine($years, $years),
                'placeholder' => 'Année de construction',
                'required' => false,
                'attr' => ['class' => 'year-picker',
                            'class' => 'form-select form-select-ms mb-'],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Studio meublé tout confort au 3ème étage sur cour d\'un immeuble charmant',
                    'class' => 'form-control', 
                ],
                'label_attr' => [
                    'class' => 'form-label', 
                ],
            ])
            ->add('privateComment', TextareaType::class, [
                'label' => 'Note privée',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Autres informations privées',
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label', 
                ],
            ])
            ->add('propertyType', ChoiceType::class, [
                'choices' => [
                    'Immeuble collectif' => 'Immeuble collectif',
                    'Immeuble individuel' => 'Immeuble individuel',
                ],
                'multiple' => false,
                'required' => false,
                'label' => false,
                'placeholder' => 'Type d\'habitat',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],

            ])
            ->add('legalRegime', ChoiceType::class, [
                'choices' => [
                    'Copropriété' => 'Copropriété',
                    'Mono propriété' => 'Mono propriété',
                ],
                'label' => false,
                'multiple' => false,
                'required' => false,
                'placeholder' => 'Régime juridique',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('parking', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'N° de parking',
                            'class' => 'form-control'],
            ])
            ->add('dependency', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Autres dépendances',
                            'class' => 'form-control'],
            ])
            ->add('cellarType', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'N° de cave',
                            'class' => 'form-control'],
            ])
            ->add('buildingLot', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'N° lot',
                            'class' => 'form-control'],
            ])
            ->add('thousandths', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Millièmes',
                            'class' => 'form-control'],
            ])
            ->add('equipment', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'multiple' => true,
                'placeholder' => false,
                'choices' => [
                    'Accès Internet' => 'Accès Internet',
                    'Aire de jeux' => 'Aire de jeux',
                    'Balcon' => 'Balcon',
                    'Câble/Fibre' => 'Câble/Fibre',
                    'Chauffage collectif' => 'Chauffage collectif',
                    'Eau chaude collective' => 'Eau chaude collective',
                    'Garage à vélo' => 'Garage à vélo',
                    'Interphone' => 'Interphone',
                    'Laverie' => 'Laverie',
                    'Piscine' => 'Piscine',
                    'Système de sécurité' => 'Système de sécurité',
                    'Volet roulant' => 'Volet roulant',
                    'Air conditionné' => 'Air conditionné',
                    'Ascenseur' => 'Ascenseur',
                    'Cave' => 'Cave',
                    'Garage' => 'Garage',
                    'Jardin' => 'Jardin',
                    'Parking' => 'Parking',
                    'Terrasse' => 'Terrasse',
                ],
                'attr' => [
                    'class' => 'form-check-input custom-checkbox-grid'
                ],
            ]);

        /*
        ->add('lastUpdateImage', textType::class, [
            'label' => 'Rue*',
            'required' => true,
        ])*/
        // ->add('property', EntityType::class, [
        //      'class' => Property::class,
        //      'choice_label' => 'id',
        //  ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Description::class,
        ]);
    }
}
