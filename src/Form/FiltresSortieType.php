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
                'placeholder' => 'TOUS',
                'choice_label' => 'nom',
                'required'=>false,
                'empty_data'=>null
            ])
            ->add('search', TextType::class, [
                'label' => "Rechercher : ",
                'required'=>false,
                'empty_data' =>null,
                'attr'=>['placeholder'=>'filter']
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => "Entre ",
                'required'=>false,
                'empty_data' =>'',
                'widget' => 'single_text'
            ])
            ->add('dateLimite', DateTimeType::class, [
                'label' => " et ",
                'required'=>false,
                'empty_data' =>'',
                'widget' => 'single_text'
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",'required'=>false
            ])
            ->add('inscription', ChoiceType::class, [
                'choices'=>[
                    'Sorties auxquelles je suis inscrit'=>'oui',
                    'Sorties auxquelles je ne suis pas inscrit'=>'non',],
                'expanded'=>true,
                'required'=>false,
                'empty_data'=>null
            ])
            ->add('etat', EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=>Etat::class,
                'expanded'=>true,
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
            'crsf_protection'=>false,
            'method'=>'GET'
        ]);
    }
}
