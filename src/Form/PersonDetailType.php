<?php

namespace App\Form;

use App\Entity\leaseParty;
use App\Entity\PersonDetail;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Prénom',
                            'class' => 'form-control'],
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Nom',
                            'class' => 'form-control'],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Email',
                            'class' => 'form-control'],
            ]);

            if ($options['include_phone']) {
                $builder->add('phoneNumber', TextType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => ['placeholder' => 'Numéro de téléphone',
                                'class' => 'form-control'],
                ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonDetail::class,
            'include_phone' => true, // default value
        ]);
    }
}
