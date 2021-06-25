<?php

namespace App\Form;

use App\Entity\Deposite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepositeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (empty($options['data']->getId())) {
            // new occupancy
            $builder
                ->setAction('/deposite/new')
                ->setMethod('POST');
        }
        $builder
            ->add('amount', NULL,[
                'label' => 'deposite.label.amount',
                'attr' => [
                    'placeholder' => 'deposite.label.amount.placeholder'
                ]
            ])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('crdate')
//            ->add('tstamp')
//            ->add('booking')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deposite::class,
        ]);
    }
}
