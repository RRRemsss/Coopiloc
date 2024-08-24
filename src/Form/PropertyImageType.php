<?php

namespace App\Form;

use App\Entity\PropertyImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filePathPropertyImage', FileType::class, [
                'label' => 'Télécharger une image',
                'required' => false,
                'attr' => [
                    'accept' => 'image/jpeg,image/png,image/gif',
                    'class'=> 'form-control-file',
                ],
            ])
            // ->add('isMain');
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertyImage::class,
        ]);
    }
}
