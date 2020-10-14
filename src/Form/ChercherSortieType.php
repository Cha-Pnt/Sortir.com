<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChercherSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
            ->add('nom', SearchType::class, [
                'label' => "Le nom de la sortie contient : ",
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => "Entre ",
            ])
            ->add('dateLimite', DateType::class, [
                'label' => " et ",
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",
            ])
            ->add('inscrit', CheckboxType::class, [
                'mapped' => false, 'label' => "Sorties auxquelles je suis inscrit/e"
            ])
            ->add('nonInscrit', CheckboxType::class, [
                'mapped' => false, 'label' => "Sorties auxquelles je ne suis pas insrit/e"
            ])
            ->add('etat', CheckboxType::class, [
                'label' => "Sorties passées",
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
