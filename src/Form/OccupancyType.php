<?php

namespace App\Form;

use App\Entity\Occupancy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OccupancyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/occupancy/new')
            ->add('name')
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'placeholder' => 'dd.mm.YYYY',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Birthday:',
            ])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('tstamp')
//            ->add('crdate')
//            ->add('occupancies')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Occupancy::class,
        ]);
    }
}