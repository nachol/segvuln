<?php

namespace App\Form;

use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;




class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'label' => 'Nombre: '
            ))
            ->add('apellido', TextType::class, array(
                'label' => 'Apellido: '
            ))
            ->add('area', TextType::class, array(
                'label' => 'Área: ',
                'required' => false
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Email: '
            ))
            ->add('tel', TelType::class, array(
                'label' => 'Telefono: ',
                'required' => false
            ))
            ->add('usuarioRed', TextType::class, array(
                'label' => 'Usuario de Red: ',
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Responsable::class,
        ]);
    }
}
