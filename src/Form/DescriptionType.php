<?php

namespace App\Form;

use App\Entity\Description;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
        
        $builder
            ->add('area', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Surface'],
            ])
            ->add('numberOfRooms', TypeIntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nombre de pièces'],
            ])
            ->add('numberOfBedrooms', TypeIntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nombre de chambres'],
            ])
            ->add('numberOfBathrooms', TypeIntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nombre de salle de bain'],
            ])
            ->add('numberOfShower', TypeIntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nombre de salle d\'eau'],
            ])
            ->add('constructionDate', DateType::class, [
                'label' => 'Année de construction',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: Studio meublé tout confort au 3ème étage sur cour d\'un immeuble charmant'],
            ])
            ->add('privateComment', TextareaType::class, [
                'label' => 'Note privée',
                'required' => false,
                'attr' => ['placeholder' => 'Autres informations privées'],
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
            ])
            ->add('parking', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Parking'],
            ])
            ->add('dependency', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Autres dépendances'],
            ])
            ->add('cellarType', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Cave'],
            ])
            ->add('buildingLot', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Lot'],
            ])
            ->add('thousandths', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Millièmes'],
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
