<?php

namespace App\Form;

use App\Entity\PersonDetail;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'Pseudo*'
                ],
            ])
            ->add('password', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe*'
                ],
            ])
            ->add('type')
            ->add('personDetail', EntityType::class, [
                'class' => PersonDetail::class,
            ])
            ->add('userStreetName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Numéro et nom de la rue*',
                            'class' => 'form-control'],
            ])
            ->add('userCity', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Ville*',
                            'class' => 'form-control'],
            ])
            ->add('UserPostCode', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Code postal*',
                            'class' => 'form-control'],
            ])
            ->add('userCountryAddress', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Pays',
                            'class' => 'form-control'],
            ])
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
