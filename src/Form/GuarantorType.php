<?php

namespace App\Form;

use App\Entity\LeaseParty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuarantorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
      
        ->add('civility', ChoiceType::class, [
            'choices' => [
                'Mr' => 'Mr',
                'Mme' => 'Mme',
                'Non genré' => 'Non genré',
                'Autre' => 'Autre',
            ],
            'multiple' => false,
            'required' => true,
            'label' => false,
            'placeholder' => 'Civilité',
            'attr' => ['class' => 'form-select form-select-ms mb-3'],
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
        ->add('identityDocuments', IdentityDocumentType::class, [
            'label' => false,
            'required' => false,
        ])
        ->add('guarantorAddress', AddressType::class, [
            'label' => false,
            'required' => false,
        ])
        ->add('guarantorPersonDetail', PersonDetailType::class, [
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