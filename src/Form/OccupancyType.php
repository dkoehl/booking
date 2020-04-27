<?php

namespace App\Form;

use App\Entity\Occupancy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OccupancyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(empty($options['data']->getId())){
            // new occupancy
            $builder
                ->setAction('/occupancy/new')
                ->setMethod('POST');
        }
        $builder
            ->add('name', null, [
                'label' => 'occupancy.label.name',
                'attr' => [
                    'placeholder' => 'occupancy.label.name.placeholder'
                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'occupancy.label.birthday.placeholder'
                ],
                'label' => 'occupancy.label.birthday',
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
