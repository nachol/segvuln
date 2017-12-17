<?php

namespace App\Form;

use App\Entity\TipoVuln;
use App\Entity\Vulnerabilidad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class VulnerabilidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', EntityType::class, array(
                'class' => TipoVuln::class,
                'choice_label' => 'descripcion',
            ))
            ->add('estado', ChoiceType::class, array(
                'choices' => array(
                    'Inactivo' => 0,
                    'Activo' => 1,
                    'Aceptado' => 2
                ),
                'placeholder' => 'Choose an option',
                'preferred_choices' => array(1)
            ))
            ->add('fechaCreacion', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime('now')
            ))

            ->add('fechaModificacion', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime('now')
            ))
            ->add('comentario')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Vulnerabilidad::class,
        ]);
    }
}
