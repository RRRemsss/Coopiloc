<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Tax;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taxSystem', ChoiceType::class, [
                'choices' => [
                    'Pinel 6 ans' => 'Pinel 6 ans',
                    'Pinel 9 ans' => 'Pinel 9 ans',
                    'Revenu foncier classique Réel' => 'Revenu foncier classique Réel',
                    'Revenu foncier classique Micro' => 'Revenu foncier classique Micro',
                    'BIC Réel / location meublée' => 'BIC Réel / location meublée',
                    'BIC Micro / location meublée' => 'BIC Micro / location meublée',
                    'SCI à l\'IS' => 'SCI à l\'IS',
                    'SCI à l\'IR' => 'SCI à l\'IR',
                    'SARL de famille' => 'SARL de famille',
                    'Autres' => 'Autres',
                ],
                'multiple' => false,
                'required' => false,
                'label' => false,
                'placeholder' => 'Régime fiscal',
                'attr' => ['class' => 'form-select form-select-ms mb-3'],
            ]) 
            ->add('taxNumber', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Numéro fiscal',
                            'class' => 'form-control'],
            ])
            ->add('siret', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'SIRET',
                            'class' => 'form-control'],
            ])
            ->add('housingTax', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Montant taxe d\'habitation',
                            'class' => 'form-control'],
            ])
            ->add('dateActivityStart', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début d\'activité :',
                'required' => false,
                'attr' => ['class' => 'form-control w-50'],
            ])
            ->add('propertyTax', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Montant taxe foncière',
                            'class' => 'form-control'],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Notes sur les infos financières',
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label', 
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tax::class,
        ]);
    }
}
