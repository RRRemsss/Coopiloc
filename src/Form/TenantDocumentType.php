<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenantDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('tenantDocumentType', ChoiceType::class, [
            'choices' => [
                    'Fiche de paie' => 'paySlip',
                    'Avis d\'imposition' => 'taxNotice',
                    'CNI' => 'dni',
                    'Passeport' => 'passport',
                    'Permis de conduire' => 'drivingLicence',
                ],
            'label' => false,
            'required' => false,
            'placeholder' => 'Type de document',
            'attr' => ['class' => 'form-select form-select-ms mb-3'],
        ])
        ->add('filePathTenantDocument', FileType::class, [
            'label' => 'Insérez vos documents',
            'required' => false,
            'multiple' => true, 
            'mapped' => false, 
            'attr' => [
                'accept' => 'application/*',
                'class'=> 'form-control-file',
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
