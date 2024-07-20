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
        ->add('street', TextType::class, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'Numéro et nom de la rue'],
        ])
        ->add('building', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Bâtiment'],
        ])
        ->add('floor', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Etage'],
        ])
        ->add('city', TextType::class, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'Ville*'],
        ])
        ->add('postCode', TextType::class, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'Code postal*'],
        ])
        ->add('region', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Région'],
        ])
        ->add('country', TextType::class, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'Pays*'],
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
