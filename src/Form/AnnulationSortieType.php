<?php

namespace App\Form;


use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnulationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom de la sortie"
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => "Date de la sortie"
            ])
            ->add('campus', TextType::class, [
                'label' => "Campus"
            ])
            ->add('lieu', TextType::class, [
                'label' => "Lieu"
            ])
            ->add('motif', TextareaType::class, [
                'label' => "Motif de l'annulation",'required'=>false,'mapped'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
            'motif' =>'',
        ]);
    }
}
