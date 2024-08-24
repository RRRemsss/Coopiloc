<?php

namespace App\Form;

use App\Entity\PropertyDocument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('documentType', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'placeholder' => 'Type de document',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('filePathPropertyDocument', FileType::class, [
                'label' => 'Insérer un document',
                'required' => false,
                'attr' => [
                    'accept' => 'image/jpeg,image/png,image/gif',
                    'class'=> 'form-control-file',
                ],
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertyDocument::class,
        ]);
    }
}
