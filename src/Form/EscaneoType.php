<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Escaneo;
use App\Entity\TipoEscaneo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EscaneoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plataforma')
            ->add('fecha', DateType::class,  array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime('now')
            ))
            ->add('descripcion')
            ->add('informe')
            ->add('tipo', EntityType::class, array(
                'class' => TipoEscaneo::class,
                'choice_label' => 'descripcion',
            ))
            ->add('vulnerabilidades', CollectionType::class, array(
            'entry_type' => VulnerabilidadType::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'attr' => array(
                'class' => 'my-selector',
                ),
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Escaneo::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'EscaneoType';
    }
}
