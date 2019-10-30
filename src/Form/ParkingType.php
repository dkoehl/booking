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
            ->add('carplate')
            ->add('startdate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'placeholder' => 'dd.mm.YYYY',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'From:',
            ])
            ->add('enddate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'placeholder' => 'dd.mm.YYYY',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'To:',
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
