<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\IdentityDocument;
use App\Entity\LeaseParty;
use App\Entity\PersonDetail;
use App\Entity\Rental;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeasePartyType extends AbstractType
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
                'attr' => ['class' => 'form-select form-control-color mb-3'],
            ])
            ->add('leasePartyType', ChoiceType::class, [
                'choices' => [
                    'Locataire' => 'tenant',
                    'Garant' => 'guarantor',
                ],
                'multiple' => false,
                'required' => true,
                'label' => false,
                'placeholder' => 'Choisir partie',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('civility', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'multiple' => true,
                'placeholder' => false,
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Non genré' => 'Non genré',
                    'Autre' => 'Autre',
                ],
                'attr' => [
                    'class' => 'form-check-input custom-checkbox-grid'
                ],
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Date de naissance :',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control w-50'],
            ])
            ->add('placeOfBirth', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Lieu de naissance', 'class' => 'form-control'],
            ])
            ->add('nationality', ChoiceType::class, [
                    'choices' => [
                        'Français/e' => 'Français/e',
                        'Anglais/e' => 'Anglais/e',
                        'Espagnol/e' => 'Espagnol/eé',
                        'Italien/ne' => 'Italien/ne',
                    ],
                    'multiple' => false,
                    'required' => true,
                    'label' => false,
                    'placeholder' => 'Nationalité',
                    'attr' => ['class' => 'form-select form-select-ms mb-3'],
                ])
            ->add('profession', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Profession', 'class' => 'form-control'],
            ])
            ->add('monthlyIncome', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Revenus mensuels', 'class' => 'form-control'],
            ])
            ->add('privateComment', TextareaType::class, [
                'label' => 'Note privée',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Autres informations importantes',
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label', 
                ],
            ])
            // Supposons que vous avez commenté ces champs, décommentez-les si vous les utilisez
            // ->add('rentals', EntityType::class, [
            //     'class' => Rental::class,
            //     'label' => false,
            //     'multiple' => true,
            // ])
            ->add('identityDocuments', IdentityDocumentType::class, [
                'label' => false,
                'required' => false,
            ])
            // ->add('address', AddressType::class, [
            //     'label' => false,
            // ])
            ->add('personDetail', PersonDetailType::class, [
                'label' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LeaseParty::class,
        ]);
    }
}
