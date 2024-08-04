<?php

namespace App\Form;

use App\Entity\IdentityDocument;
use App\Entity\LeaseParty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('identityDocumentType', ChoiceType::class, [
                'choices' => [
                    'Carte d\'identité' => 'Carte d\'identité',
                    'Passeport' => 'Passeport',
                    'Permis de conduire' => 'Permis de conduire',
                    'Carte de séjour' => 'Carte de séjour',
                ],
                'multiple' => false,
                'required' => true,
                'label' => false,
                'placeholder' => 'Document d\'identité',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('identityNumber', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Numéro d\'identité',
                            'class' => 'form-control'],
            ])
            ->add('expirationDate', DateType::class, [
                'label' => 'Date d\'expiration du document :',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control w-50'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IdentityDocument::class,
        ]);
    }
}
