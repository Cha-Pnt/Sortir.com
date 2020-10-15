<?php

namespace App\Form;

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

class RechercheFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
            ->add('nom', SearchType::class, [
                'label' => "Le nom de la sortie contient : ",'required'=>false
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => "Entre ",'required'=>false
            ])
            ->add('dateLimite', DateType::class, [
                'label' => " et ",'required'=>false
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",'required'=>false
            ])
            ->add('inscrit', CheckboxType::class, [
                'mapped' => false, 'label' => "Sorties auxquelles je suis inscrit/e",'required'=>false
            ])
            ->add('nonInscrit', CheckboxType::class, [
                'mapped' => false, 'label' => "Sorties auxquelles je ne suis pas insrit/e",'required'=>false
            ])
            ->add('etat', CheckboxType::class, [
                'label' => "Sorties passées",'required'=>false
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
