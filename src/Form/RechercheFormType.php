<?php

namespace App\Form;

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
                'choice_label' => 'nom','mapped'=>false
            ])
            ->add('nom', SearchType::class, [
                'label' => "Le nom de la sortie contient : ",'required'=>false,'mapped'=>false
            ])
            ->add('date_HeureDebut', DateTimeType::class, [
                'label' => "Entre ",'required'=>false,'empty_data' =>null,'mapped'=>false
            ])
            ->add('dateLimite', DateTimeType::class, [
                'label' => " et ",'required'=>false,'empty_data' =>null, 'mapped'=>false
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",'required'=>false,'mapped'=>false
            ])
            ->add('inscrit', CheckboxType::class, [
                 'label' => "Sorties auxquelles je suis inscrit/e",'required'=>false,'mapped'=>false
            ])
            ->add('nonInscrit', CheckboxType::class, [
                 'label' => "Sorties auxquelles je ne suis pas insrit/e",'required'=>false,'mapped'=>false
            ])
            ->add('etat', CheckboxType::class, [
                'label' => "Sorties passées",'required'=>false,'mapped'=>false
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
