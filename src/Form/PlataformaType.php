<?php

namespace App\Form;

use App\Entity\Plataforma;
use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PlataformaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextType::class, array(
            'label' => 'Nombre: ',
            'required' => true
        ))
            ->add('ubicacion', TextType::class, array(
            'label' => 'Ubicación: ',
            'required' => false
        ))
            ->add('responsable', EntityType::class, array(
            'label' => 'Nombre: ',
            'required' => true,
            'class' => Responsable::class,
        ))  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Plataforma::class,
        ]);
    }
}
