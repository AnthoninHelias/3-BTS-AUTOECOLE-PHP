<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Lecon;
use App\Entity\Moniteur;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y'),date('Y')+10)
            ))
            ->add('heure')
            ->add('reglee', ChoiceType::class, [
                'choices'  => [
                    'Non' => 0,
                ],
            ])

            ->add('immatriculation', EntityType::class,[
                'class' => Vehicule::class,
                'choice_label' => 'modele'
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lecon::class,
        ]);
    }
}
