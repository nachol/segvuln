<?php

namespace App\Form;

use App\Entity\TipoVuln;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TipoVulnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextType::class, array(
            'label' => 'Descripción: ',
            'required' => true
        ))
            ->add('criticidad', ChoiceType::class, array(
                'choices' => array(
                    'Crítica' => 0,
                    'Alta' => 1,
                    'Media' => 2
                ),
                'placeholder' => 'Choose an option',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => TipoVuln::class,
        ]);
    }
}
