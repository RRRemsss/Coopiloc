<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Parking' => 'Parking',
                    'Studio' => 'Studio',
                    'Garage' => 'Garage',
                ],
                'multiple' => false,
                'required' => true,
                'label' => false,
                'placeholder' => 'Type de bien',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ])
            ->add('namePlace', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nom du bien',
                            'class' => 'form-control'],
            ])
            ->add('color', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    '' => '',
                    'Rouge' => '#FF0000',
                    'Vert foncé' => '#226D68',
                    'Vert clair' => '#2CCED2',
                    'Bleu' => '#5784BA',
                    'Orange' => '#F27438',
                    'Violet' => '#C49FFF',
                    'Rose' => '#DB6A8F',
                    'Jaune' => '#FFEB69',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return $choice === '' ? 'Choix couleur' : $key;
                },
                'choice_attr' => function ($choice, $key, $value) {
                    return $choice === '' ? [] : ['style' => sprintf('background-color: %s;', $value)];
                },
                'placeholder' => 'Couleur',
                'attr' => ['class' => 'form-select form-control-color mb-3'],
                'required' => false,
            ])
            ->add('acquisitionDate', DateType::class, [
                'label' => 'Date d\'acquisition du bien :',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control w-50'],
            ])
            ->add('acquisitionPrice', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Prix d\'acquisition',
                            'class' => 'form-control'],
            ])
            ->add('acquisitionFee', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Frais d\'acquisition',
                            'class' => 'form-control'],
            ])
            ->add('agencyFee', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Frais d\'agence',
                            'class' => 'form-control'],
            ])
            ->add('propertyValue', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Valeur actuelle',
                            'class' => 'form-control'],
            ])
            ->add('address', AddressType::class, [
                'label' => false,
            ])
            ->add('descriptions', CollectionType::class, [
                'entry_type' => DescriptionType::class,
                'label' => false,
            ])
            ->add('rentals', CollectionType::class, [
                'entry_type' => RentalType::class,
                'label' => false,
            ])
            ->add('taxes', CollectionType::class, [
                'entry_type' => TaxType::class,
                'label' => false,
            ])        
            ->add('propertyImages', FileType::class, [
                'label' => 'Images',
                'multiple' => true, // Permet de télécharger plusieurs fichiers
                'required' => false, // Le champ n'est pas obligatoire
                'mapped' => false,
                'attr' => [
                    'accept' => 'image/jpeg,image/png,image/gif',
                ],
            ])
            ->add('propertyDocuments', FileType::class, [
                'label' => 'Documents',
                'multiple' => true, // Permet de télécharger plusieurs fichiers
                'required' => false, // Le champ n'est pas obligatoire
                'mapped' => false,
                'attr' => [
                    'accept' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ],
            ])
        ;
        

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
