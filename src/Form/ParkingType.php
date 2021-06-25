<?php

namespace App\Form;

use App\Entity\Parking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParkingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (empty($options['data']->getId())) {
            // new occupancy
            $builder
                ->setAction('/parking/new')
                ->setMethod('POST');
        }
        $builder
            ->add('carplate', null, [
                'label' => 'parking.label.carplate',
                'attr' => [
                    'placeholder' => 'parking.label.carplate.placeholder'
                ]
            ])
            ->add('startdate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'YYYY-mm-dd',
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'parking.label.startdate.placeholder'
                ],
                'label' => 'parking.label.startdate',
            ])
            ->add('enddate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'YYYY-mm-dd',
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'parking.label.enddate.placeholder'
                ],
                'label' => 'parking.label.enddate',
            ])
            ->add('parkingspot', null, [
                'label' => 'parking.label.parkingspot',
                'attr' => [
                    'placeholder' => 'parking.label.parkingspot.placeholder'
                ]
            ])
            ->add('price', null, [
                'label' => 'parking.label.price',
                'attr' => [
                    'placeholder' => 'parking.label.price.placeholder'
                ]
            ])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('crdate')
//            ->add('tstamp')
//            ->add('parking')
//            ->add('booking')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parking::class,
        ]);
    }
}
