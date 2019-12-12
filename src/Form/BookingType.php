<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookingfrom', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'label' => 'booking.label.from',
                'attr' => [
                    'placeholder' => 'YYYY-mm-dd',
                ],
            ])
            ->add('bookingtill', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'attr' => [
                    'placeholder' => 'YYYY-mm-dd',
                ],
                'label' => 'booking.label.to',
            ])
//            ->add('room', CollectionType::class, [
//                'entry_type' => RoomType::class,
//                'entry_options' => ['label' => true],
//            ])
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'houseName',
                'multiple' => true,
                'label' => 'booking.label.room',
                'attr' => ['class' => 'hide'],
            ])
            ->add('guest', EntityType::class, [
                'class' => Guest::class,
                'choice_label' => 'lastnameFirstname',
                'multiple' => false,
                'label' => 'booking.label.guest',
                'attr' => ['class' => 'hide'],

            ])
        ;
//            ->add('room', HiddenType::class,[])
//            ->add('guest', HiddenType::class,[]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
