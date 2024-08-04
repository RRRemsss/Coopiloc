<?php

namespace App\Form;

use App\Entity\IdentityDocument;
use App\Entity\PersonDetail;
use App\Entity\Rental;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('color', ChoiceType::class, [
            'label' => false,
            'choices' => [
                '' => '',
                'Rouge' => '#FF0000',
                'Vert foncé' => '#226D68',
                'Vert clair' => '#2CCED2',
                'Bleu' => '#5784BA',
                'Orange' => '#F27438',
                'Violet' => '#C49FFF',
                'Rose' => '#DB6A8F',
                'Jaune' => '#FFEB69',
            ],
            'choice_label' => function ($choice, $key, $value) {
                return $choice === '' ? 'Choix couleur' : $key;
            },
            'choice_attr' => function ($choice, $key, $value) {
                return $choice === '' ? [] : ['style' => sprintf('background-color: %s;', $value)];
            },
            'placeholder' => 'Couleur',
            'attr' => ['class' => 'form-select form-control-color mb-3'],
            'required' => false,
        ])
            ->add('civility', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'multiple' => false,
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
            ->add('hasGuarantor', ChoiceType::class, [
                'label' => 'Il y a-t-il un garant ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'data' => false, //default value
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-check-input'],
                'label_attr'=> ['class'=> 'form-label me-3'],
            ])
            ->add('tenants', EntityType::class, [
                'class' => Rental::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('identityDocument', EntityType::class, [
                'class' => IdentityDocument::class,
                'choice_label' => 'id',
            ])
            ->add('personDetail', EntityType::class, [
                'class' => PersonDetail::class,
                'choice_label' => 'id',
            ])
            ->add('guarantors', CollectionType::class, [
                'entry_type' => GuarantorType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tenant::class,
        ]);
    }
}
