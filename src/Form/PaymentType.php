<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/payment/new')
            ->add('payment', NULL, [
                'label' => 'payment.label.payment',
                'attr' => [
                    'placeholder' => 'payment.label.payment.placeholder'
                ]
            ])
            ->add('number', NULL, [
                'label' => 'payment.label.number',
                'attr' => [
                    'placeholder' => 'payment.label.number.placeholder'
                ]
            ])
            ->add('securitynumber', NULL, [
                'label' => 'payment.label.securitynumber',
                'attr' => [
                    'placeholder' => 'payment.label.securitynumber.placeholder'
                ]
            ])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('crdate')
//            ->add('tstamp')
//            ->add('payments')
//            ->add('booking')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
