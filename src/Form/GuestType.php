<?php

namespace App\Form;

use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(empty($options['data']->getId())){
            // new guest
            $builder
                ->setAction('/guest/new')
                ->add('bookings', HiddenType::class, [])
                ->setMethod('POST');
        }
            // edit guest
            $builder
                ->add('type', HiddenType::class, [])
                ->add('companyname', null, [
                    'label' => 'guest.label.companyname',
                    'attr' => [
                        'placeholder' => 'guest.label.companyname.placeholder'
                    ],
                ])
                ->add('address', TextareaType::class, [
                    'label' => 'guest.label.address',
                    'attr' => [
                        'class' => 'materialize-textarea',
                        'placeholder' => 'guest.label.address.placeholder'
                    ]
                ])
                ->add('taxnumber', null, [
                    'label' => 'guest.label.taxnumber',
                    'attr' => [
                        'placeholder' => 'guest.label.taxnumber.placeholder'
                    ]
                ])
                ->add('signatureauthorized')
                ->add('lastname', null, [
                    'label' => 'guest.label.lastname',
                    'attr' => [
                        'placeholder' => 'guest.label.lastname.placeholder'
                    ]
                ])
                ->add('firstname', null, [
                    'label' => 'guest.label.firstname',
                    'attr' => [
                        'placeholder' => 'guest.label.firstname.placeholder'
                    ]
                ])
                ->add('birthday', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => true,
                    'format' => 'YYYY-mm-dd',
                    'attr' => [
                        'placeholder' => 'guest.label.birthday.placeholder'
                    ],
                    'label' => 'guest.label.birthday',
                ])
//                ->add('bookings', CollectionType::class, [
//                    'attr' => ['class' => 'hide']
//                ])
               
                ->add('placeofbirth', null, [
                    'label' => 'guest.label.placeofbirth',
                    'attr' => [
                        'placeholder' => 'guest.label.placeofbirth.placeholder'
                    ]
                ])
//            ->add('country', CountryType::class, [
//                'label' => 'Country of birth',
//            ])
                ->add('country', null, [
                    'label' => 'guest.label.country',
                    'attr' => [
                        'placeholder' => 'guest.label.country.placeholder'
                    ]
                ])
                ->add('phone', null, [
                    'attr' => ['placeholder' => '+49 89 22223333']
                ])
                ->add('email', null, [
                    'attr' => ['placeholder' => 'Email Address']
                ])
                ->add('personalid', HiddenType::class, [

                ])
                ->add('city', null, [
                    'label' => 'guest.label.city',
                    'attr' => [
                        'placeholder' => 'guest.label.city.placeholder'
                    ]
                ])
                ->add('zipcode', null, [
                    'label' => 'guest.label.zipcode',
                    'attr' => [
                        'placeholder' => 'guest.label.zipcode.placeholder'
                    ]
                ])
            ;
        
        
//        dump($builder);
//        dump($this);
//        dump($options['data']->getId());
//        die('here');
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}
