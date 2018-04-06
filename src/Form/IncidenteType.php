<?php

namespace App\Form;

use App\Entity\Incidente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class IncidenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
                //'empty_data' => new \DateTime('now')
            ))
            ->add('nombre')
            ->add('ticket')
            ->add('informe', ChoiceType::class, array(
                'choices' => array(
                    'Si' => true,
                    'No' => false,
                ),
                'placeholder' => 'Choose an option',
                'expanded' => true
            ))
            ->add('descripcion')
            ->add('criticidad', ChoiceType::class, array(
                'choices' => array(
                    'Crítico' => 3,
                    'Alto' => 2,
                    'Medio' => 1,
                    'Bajo' => 0
                ),
                'placeholder' => 'Elija Criticidad',
                'expanded' => true
            ))
            ->add('estado', ChoiceType::class, array(
                'choices' => array(
                    'Cerrado' => true,
                    'Pendiente' => false,
                ),
                'placeholder' => 'Choose an option',
                'expanded' => true
            ))
            ->add('cierre', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Incidente::class,
        ]);
    }
}
