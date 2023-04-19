<?php

namespace App\Form;

use App\ChoiceInterface;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sexe', ChoiceType::class, [
                'choices'  => ChoiceInterface::sexe
            ])
            ->add('email')
            ->add('password')
            ->add('roles', ChoiceType::class, [
                'choices'  => ChoiceInterface::roles
            ])
            ->add('adresse')
            ->add('codepostal')
            ->add('ville')
            ->add('telephone')
            ->add('datedenaissance', DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y'),date('Y')-100)
            ))
            ->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0]: null,
                    fn ($rolesAsString) => [$rolesAsString]
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
