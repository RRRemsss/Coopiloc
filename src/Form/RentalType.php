<?php

namespace App\Form;

use App\Entity\leaseParty;
use App\Entity\Property;
use App\Entity\Rental;
use App\Repository\LeasePartyRepository;
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
        ->add('startDate', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Date du bail',
            'required' => true,
        ])
        ->add('endDate', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Fin de bail',
            'required' => true,
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
                'attr' => ['placeholder' => 'Type de bail'],
            ])
            ->add('netRent', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Loyer hors charges'],
            ])
            ->add('grossRent', TextType::class, [
                'label' => false,
                'required' => true,
                'scale' => 2,
                'attr' => ['readonly' => true,
                            'placeholder' => 'Montant total du loyer'],
            ])
            ->add('charge', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Charges'],
            ])
            ->add('deposit', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Dépot de garantie'],
            ])            
            ->add('reference', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Identifiant'],
            ])
            ->add('purposeUse', ChoiceType::class, [
                'choices' => [
                    'Résidence principale du locataire' => 'Résidence principale du locataire',
                    'Résidence secondaire du locataire' => 'Résidence secondaire du locataire'
                ],
                'label' => false,
                'attr' => ['placeholder' => 'Usage'],
                'multiple' => false,
                'required' => true,
            ])
            ->add('duration', ChoiceType::class, [
                'choices' => [
                    '1 an' => '1 an',
                    '3 ans' => '3 ans',
                    '9 mois' => '9 mois',
                    '9 ans' => '9 ans',
                ],
                'label' => false,
                'attr' => ['placeholder' => 'Durée du bail'],
                'multiple' => false,
                'required' => true,
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
                'attr' => ['placeholder' => 'Echéancier'],
                'multiple' => false,
                'required' => true,
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
                'attr' => ['placeholder' => 'Moyen de paiement'],
                'multiple' => false,
                'required' => true,
            ])
            ->add('paymentDate', ChoiceType::class, [
                //La méthode "array_combine" crée un tableau associatif avec les clés et les valeurs de 1 à 31.
                //Cela permettra à l'utilisateur de choisir une valeur entre 1 et 31, mais pas 0.
                'choices' => array_combine(range(1, 31), range(1, 31)),
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Date de paiement'],
            ])
            ->add('privateComment', TextareaType::class, [
                'label' => 'Note privée',
                'required' => false,
                'attr' => ['placeholder' => 'Autres informations privées'],
            ])

            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'id',
            ])
            // ->add('leaseParties', EntityType::class, [
            //     'class' => leaseParty::class,
            //     'query_builder' => function (LeasePartyRepository $repository) {
            //         return $repository->findAvailableTenants();
            //     },
            //     'choice_label' => function (leaseParty $tenant) {
            //         return sprintf('%s %s', $tenant->getLastname(), $tenant->getFirstname());
            //     },
            //     'label' => 'Mes biens enregistrés',
            //     'required' => true,
            // ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
