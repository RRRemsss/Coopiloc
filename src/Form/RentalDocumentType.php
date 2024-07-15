<?php

namespace App\Form;

use App\Entity\Rental;
use App\Entity\RentalDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receiptDate')
            ->add('noticeRentDueDate')
            ->add('uploadRentalDocumentPath')
            ->add('rental', EntityType::class, [
                'class' => Rental::class,
                'choice_label' => 'id',
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
