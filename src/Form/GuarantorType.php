<?php

namespace App\Form;

use App\Entity\Guarantor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'label' => false,
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'required' => false,
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
                    'required' => false,
                    'label' => false,
                    'placeholder' => 'Nationalité',
                    'attr' => ['class' => 'form-select form-select-ms mb-3'],
                ])
            ->add('profession', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Profession', 
                            'class' => 'form-control'],
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
            ->add('guarantorType', ChoiceType::class, [
                'choices' => [
                    'Particulier' => 'particulier',
                    'Société/Autre' => 'company',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'label' => 'Type de garant :',
                'placeholder' => false,
                'attr' => [
                    'class' => 'form-check-input custom-checkbox-grid'
                ],
            ])
            ->add('guarantorCompanyName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nom de la société garante', 'class' => 'form-control'],
            ])
            ->add('address', AddressType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('personDetail', PersonDetailType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('identityLeaseParty', IdentityLeasePartyType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('guarantorDocuments', FileType::class, [
                'label' => 'Veuillez insérer le justificatif',
                'multiple' => true, 
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'accept' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ],
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
