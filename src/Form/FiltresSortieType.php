<?php

namespace App\Form;

use App\Data\Recherche;
use App\Entity\Campus;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
                'choice_label' => 'nom',
                'empty_data'=>null
            ])
            ->add('search', TextType::class, [
                'label' => "Rechercher : ",
                'required'=>false,
                'empty_data' =>null,
                'attr'=>['placeholder'=>'filter']
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => "Entre ",'required'=>false,

            ])
            ->add('dateLimite', DateTimeType::class, [
                'label' => " et ",
                'required'=>false,
                'empty_data' =>null
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",'required'=>false
            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => "Sorties auxquelles je suis inscrit/e",'required'=>false
            ])
            ->add('nonInscrit', CheckboxType::class, [
                'label' => "Sorties auxquelles je ne suis pas insrit/e",'required'=>false
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
