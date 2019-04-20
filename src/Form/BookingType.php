<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookingfrom', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'From: ',
                'attr' => ['class' => 'js-datepicker '],
            ])
            ->add('bookingtill', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'To:',
            ])
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'houseName',
                'multiple' => true,
                'attr' => ['class' => 'js-example-basic-multiple'],
            ])
            ->add('guest', EntityType::class, [
                'class' => Guest::class,
                'choice_label' => 'lastnameFirstname',
                'multiple' => false,
                'attr' => ['class' => 'js-example-basic-multiple'],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
