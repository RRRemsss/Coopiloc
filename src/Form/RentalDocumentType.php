<?php

namespace App\Form;

use App\Entity\Rental;
use App\Entity\RentalDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hasOtherAddress', CheckboxType::class, [
                'label' => 'Cocher si l\'adresse de quittancement est autre que l\'adresse du bien loué',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input-receiptAddress custom-checkbox-grid'
                ],
            ])
            ->add('otherAddress', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Adresse de quittancement si différente de l\'adresse du bien loué',
                            'class' => 'form-control'],
                'label_attr' => [
                    'class' => 'form-label', 
                ],
            ])
            ->add('issueDate', ChoiceType::class, [
                'label' => false,
                'choices' => array_combine(range(1, 31), range(1, 31)),
                'placeholder' => 'Jour de début de la quittance',
                'required' => false,
                'attr' => ['class' => 'form-control form-select'],
            ])
            ->add('dueDate', ChoiceType::class, [
                'label' => false,
                'choices' => array_combine(range(-1, -31), range(31, 1)),
                'placeholder' => 'Génération du loyer (en jour)',
                'required' => false,
                'attr' => ['class' => 'form-control form-select'],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentalDocument::class,
        ]);
    }
}
