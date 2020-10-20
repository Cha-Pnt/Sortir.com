<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut',DateTimeType::class, [
                'label' => "Date et heure de la sortie",
                'required'=>true,
                'empty_data' =>'',
                'widget' => 'single_text'])
            ->add('duree')
            ->add('dateLimite',
                    DateTimeType::class, [
                    'label' => "Date Limite ",
                    'required'=>true,
                    'empty_data' =>'',
                    'widget' => 'single_text'])
            ->add('nbInscriptionsMax')
            ->add('description')
//            ->add('etat')
            ->add('lieu')
            ->add('campus')
            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('publierLaSortie', SubmitType::class, ['label' => 'Publier la sortie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
