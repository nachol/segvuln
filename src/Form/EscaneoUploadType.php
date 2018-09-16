<?php

namespace App\Form;

use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Plataforma;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EscaneoUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('plataforma', EntityType::class, array(
            'class' => Plataforma::class,
            'attr' => array('style' => 'width: 200px;')
        ))
        ->add('attachment', FileType::class)
        ->add('herramienta', ChoiceType::class, array(
            'choices' => array(
                'Nessus' => 0,
                'AppScan' => 1,
                'Acunetix' => 2
            ),
            'placeholder' => 'Choose an option',
            'expanded' => true
        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Responsable::class,
        ]);
    }
}
