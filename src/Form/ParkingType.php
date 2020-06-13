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
        $builder
            ->setAction('/parking/new')
            ->add('carplate', NULL, [
                'label' => 'parking.label.carplate',
                'attr' => [
                    'placeholder' => 'parking.label.carplate.placeholder'
                ]
            ])
            ->add('startdate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'parking.label.startdate.placeholder'
                ],
                'label' => 'parking.label.startdate',
            ])
            ->add('enddate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'parking.label.enddate.placeholder'
                ],
                'label' => 'parking.label.enddate',
            ])
            ->add('parkingspot', NULL, [
                'label' => 'parking.label.parkingspot',
                'attr' => [
                    'placeholder' => 'parking.label.parkingspot.placeholder'
                ]
            ])
            ->add('price', NULL, [
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
