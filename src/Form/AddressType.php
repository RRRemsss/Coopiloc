<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('streetName', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Numéro et nom de la rue',
                        'class' => 'form-control'],
        ])
        ->add('building', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Bâtiment',
                        'class' => 'form-control'],
        ])
        ->add('floor', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Etage',
                        'class' => 'form-control'],
        ])
        ->add('city', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Ville*',
                        'class' => 'form-control'],
        ])
        ->add('postCode', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Code postal*',
                        'class' => 'form-control'],
        ])
        ->add('region', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Région',
                        'class' => 'form-control'],
        ])
        ->add('country', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Pays',
                        'class' => 'form-control'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
