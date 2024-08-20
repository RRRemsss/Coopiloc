<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Rental;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'attr' => ['class' => 'form-select form-control-color'],
                'required' => false,
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Début du bail : ',
                'required' => true,
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'form-control w-50 startDate',                        
                ],
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fin de bail :',
                'required' => true,
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'form-control w-50 endDate',
                ],
            ])
            ->add('leaseType', ChoiceType::class, [
                'choices' => [
                    'Bail d\'habitation vide' => 'Bail d\'habitation vide',
                    'Bail d\'habitation meublé' => 'Bail d\'habitation meublé',
                    'Bail meublé étudiant' => 'Bail meublé étudiant',
                    'Bail commercial' => 'Bail commercial'
                ],
                'multiple' => false,
                'label' => false,
                'required' => true,
                'placeholder' => 'Type de bail',
                'attr' => ['class' => 'form-select form-control'],
            ])
            ->add('netRent', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Loyer hors ch.',
                    'class' => 'form-control netRent',
                ],
            ])
            ->add('grossRent', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'readonly' => true,
                    'placeholder' => 'Total loyer',
                    'class' => 'form-control grossRent',
                ],
            ])
            ->add('charge', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Charges',
                    'class' => 'form-control charge',
                ],
            ])
            ->add('housingAssistance', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Paiement APL/CAF ',
                            'class' => 'form-control'],
            ])
            ->add('deposit', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Dépot de garantie',
                            'class' => 'form-control'],
            ])            
            // ->add('reference', TextType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'attr' => ['placeholder' => 'Identifiant'],
            // ])
            ->add('purposeUse', ChoiceType::class, [
                'choices' => [
                    'Résidence principale' => 'Résidence principale',
                    'Résidence secondaire' => 'Résidence secondaire'
                ],
                'label' => false,
                'placeholder' => 'Usage du locataire',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-select form-control'],
            ])
            ->add('duration', ChoiceType::class, [
                'choices' => [
                    '1 an' => '1 an',
                    '3 ans' => '3 ans',
                    '9 mois' => '9 mois',
                    '9 ans' => '9 ans',
                ],
                'placeholder' => 'Durée du bail',
                'label' => false,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-select form-control duration',
                ],
            ])
            ->add('paymentPeriod', ChoiceType::class, [
                'choices' => [
                    'Mensuel' => 'Mensuel',
                    'Bimensuel' => 'Bimensuel',
                    'Trimestriel' => 'Trimestriel',
                    'Quadrimestriel' => 'Quadrimestriel',
                    'Semestriel' => 'Semestriel',
                    'Annuel' => 'Annuel',

                ],
                'label' => false,
                'placeholder' => 'Echéancier',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-select form-control'],
            ])
            ->add('paymentMethod', ChoiceType::class, [
                'choices' => [
                    'Virement' => 'Virement',
                    'Prélèvement automatique' => 'Prélèvement automatique',
                    'Espèce' => 'Espèce',
                    'Chèque' => 'Chèque',
                    'Carte de crédit' => 'Carte de crédit',
                ],
                'label' => false,
                'placeholder' => 'Moyen de paiement',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-select form-control'],
            ])
            ->add('paymentDate', ChoiceType::class, [
                //La méthode "array_combine" crée un tableau associatif avec les clés et les valeurs de 1 à 31.
                //Cela permettra à l'utilisateur de choisir une valeur entre 1 et 31, mais pas 0.
                'choices' => array_combine(range(1, 31), range(1, 31)),
                'label' => false,
                'required' => false,
                'placeholder' => 'Date de paiement',
                'attr' => ['class' => 'form-select form-control'],
            ])
            ->add('privateComment', TextareaType::class, [
                'label' => 'Note privée',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Autres informations importantes',
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label', 
                ],
            ])
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'namePlace',
                'label' => false,
                'placeholder' => 'Choisir un logement',
                'attr' => ['class' => 'form-select form-control'],
            ])
            ->add('tenants', EntityType::class, [
                'class' => Tenant::class,
                'choice_label' => 'fullName', // Utilisez la méthode getFullName()
                'multiple' => true,
                'expanded' => false,
                'label' => false,
                'placeholder' => 'Choisir locataire',
                'attr' => ['class' => 'form-select',
                           'size' => 3,],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
            'tenant_choices' => [],  // Add the tenant choices option
        ]);
    }
}
