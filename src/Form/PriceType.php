<?php

namespace App\Form;

use App\Entity\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/price/new')
            ->add('type', ChoiceType::class, [
                'label' => 'price.label.type',
                'attr' => [
                  'placeholder' => 'price.label.type.placeholder'
                ],
                'choices' => [
                    'Please choose' => null,
                    'price.option.type.1' => '1',
                    'price.option.type.2' => '2',
//                    '3' => '3',
//                    '4' => '4',
//                    '5' => '5',
                ],
            ])
            ->add('price', NULL, [
                'label' => 'price.label.price',
                'attr' => [
                    'placeholder' => 'price.label.price.placeholder'
                ]
            ])
            ->add('tax', NULL, [
                'label' => 'price.label.tax',
                'attr' => [
                    'placeholder' => 'price.label.tax.placeholder'
                ]
            ])
            ->add('paymentmethod', ChoiceType::class, [
                'label' => 'price.label.paymentmethod',
                'attr' => [
                    'placeholder' => 'price.label.paymentmethod.placeholder'
                ],
                'choices' => [
                    'Please choose' => null,
                    'price.option.paymentmethod.1' => '1',
                    'price.option.paymentmethod.2' => '2',
                    'price.option.paymentmethod.3' => '3',
                ],
            ])
            ->add('amount', NULL, [
                'label' => 'price.label.amount',
                'attr' => [
                    'placeholder' => 'price.label.amount.placeholder'
                ]
            ])
//            ->add('booking', HiddenType::class,[])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('crdate')
//            ->add('tstamp')
//            ->add('prices')
//            ->add('booking')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
