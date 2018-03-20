<?php

namespace App\Form;

use App\Entity\Cyberthreats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class CyberthreatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referencia')
            ->add('tipo', ChoiceType::class, array(
                'choices' => array(
                    'Activismo' => 0,
                    'Exposición de Información' => 1,
                    'Hacktivismo' => 2,
                    'Vulneración Mecanismos Seguridad' => 3,
                    'CVEs & Boletín de Seguridad' => 4,
                    'Robo de Credenciales' => 5,
                    'Uso No Autorizado de Marca' => 6,
                    'Dominios Sospechosos' => 7,
                    'Contenidos Ofensivos' => 8,
                    'Counterfeit' => 9,
                    'Seguimiento Identidad Digital' => 10,
                    'Phishing y Pharming' => 11,
                    'Malware' => 12,
                    'Carding' => 13,
                    'Apps Móviles Sospechosas' => 14
                ),
                'placeholder' => 'Choose an option',
            ))
            ->add('riesgo', ChoiceType::class, array(
                'choices' => array(
                    'Bajo' => 0,
                    'Medio' => 1,
                    'Alto' => 2,
                    'Muy Alto' => 3,
                ),
                'placeholder' => 'Choose an option',
            ))
            ->add('deteccion', DateType::class,  array(
                'widget' => 'single_text',  
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],    
                //'empty_data' => new \DateTime('now')
            ))
            ->add('notificacion', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
                //'empty_data' => new \DateTime('now')
            ))
            ->add('cierre', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
                //'empty_data' => new \DateTime('now')
            ))
            ->add('estado', ChoiceType::class, array(
                'choices' => array(
                    'Pendiente' => 0,
                    'Cerrado' => 1,
                ),
                'placeholder' => 'Choose an option',
            ))
            ->add('observaciones')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Cyberthreats::class,
        ]);
    }
}
