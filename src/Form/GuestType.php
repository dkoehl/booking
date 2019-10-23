<?php

namespace App\Form;

use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('birthday', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Birthday:',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}
