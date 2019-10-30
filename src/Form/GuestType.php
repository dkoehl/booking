<?php

namespace App\Form;

use App\Entity\Guest;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/guest/new')
            ->setMethod('POST')
            ->add('lastname')
            ->add('firstname')
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'YYYY-mm-dd',
                'placeholder' => 'dd.mm.YYYY',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Birthday:',
            ])
            ->add('bookings', HiddenType::class,[])
            ->add('placeofbirth')
            ->add('country', CountryType::class, [
                'label' => 'Country of birth',
            ])
            ->add('phone')
            ->add('email')
            ->add('personalid')
            ->add('type',ChoiceType::class, [
                'choices' => [
                    'Please choose' => null,
                    'Personal' => '1',
                    'Company' => '2',
                    'Group' => '3',
                ],
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
