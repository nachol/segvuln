<?php

namespace App\Form;

use App\Entity\TipoVuln;
use App\Entity\Vulnerabilidad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class VulnerabilidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip', TextType::class, array(
                'label' => 'Host',
                'required' => false,

            ))
            ->add('port', IntegerType::class, array(
                'label' => 'Port',
                'required' => false,

            ))
            ->add('tipo', EntityType::class, array(
                'class' => TipoVuln::class,
                'choice_label' => 'descripcion',
            ))
            ->add('estado', ChoiceType::class, array(
                'choices' => array(
                    'Remediado' => 0,
                    'Activo' => 1,
                    'Asumido' => 2
                ),
                'placeholder' => 'Choose an option',
                'preferred_choices' => array(1)
            ))
            ->add('fechaCreacion', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                //'empty_data' => new \DateTime('now')
            ))

            ->add('fechaModificacion', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
                // 'data' => new \DateTime('now')
            ))
            ->add('comentario')
            ->add('cantidad', IntegerType::class, array(
                //'mapped' => false,
                'data' => 1,
                'label' => 'Cantidad (for bulk creation)',
                'scale' => 0
            ))

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
