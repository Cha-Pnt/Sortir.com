<?php

namespace App\Form;

use App\Data\Recherche;
use App\Entity\Campus;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltresSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'placeholder' => 'CAMPUS',
                'choice_label' => 'nom',
                'required' => false,
                'empty_data' => null
            ])
            ->add('search', TextType::class, [
                'label' => "Rechercher : ",
                'required' => false,
                'empty_data' => null,
                'attr' => ['placeholder' => 'Rechercher : par nom..']
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => "Date de début ",
                'required' => false,
                'empty_data' => '',
                'widget' => 'single_text'
            ])
            ->add('dateLimite', DateTimeType::class, [
                'label' => " Date limite d'inscription ",
                'required' => false,
                'empty_data' => '',
                'widget' => 'single_text',
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Mes sorties", 'required' => false
            ])
            ->add('inscription', ChoiceType::class, [
                'label' => ' ',
                'placeholder'=>null,
                'required' => false,
                'choices' => [
                    'Mes inscriptions' => 'oui',
                    'Non inscrit' => 'non',
                ],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'inscription_' . strtolower($value)];
                },
                'expanded' => true,
                'empty_data' => null
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'placeholder' => 'ETATS',
                'choice_label' => 'libelle',
                'required' => false,
                'empty_data' => null,

            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
            'crsf_protection' => false,
            'method' => 'GET'
        ]);
    }
}
