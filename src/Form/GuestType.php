<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Guest;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                ->setMethod('POST')
                ->add('type', HiddenType::class, [])
                ->add('companyname', null, [
                    'attr' => ['placeholder' => 'Acme Inc.'],
                ])
                ->add('address', TextareaType::class, [
                    'attr' => ['class' => 'materialize-textarea']
                ])
                ->add('taxnumber')
                ->add('signatureauthorized')
        
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
//                ->add('bookings', CollectionType::class, [
//                    'attr' => ['class' => 'hide']
//                ])
                ->add('bookings', HiddenType::class, [])
                ->add('placeofbirth', null, [
                    'label' => 'City of birth'
                ])
//            ->add('country', CountryType::class, [
//                'label' => 'Country of birth',
//            ])
                ->add('country', null, [
                    'label' => 'Country of birth',
                ])
                ->add('phone', null, [
                    'attr' => ['placeholder' => '+49 89 22223333']
                ])
                ->add('email', null, [
                    'attr' => ['placeholder' => 'Email Address']
                ])
                ->add('personalid', null, [
                    'label' => 'Photo of ID'
                ]);
        }else{
            // edit guest
            $builder
//                ->setAction('/guest/new')
                ->setMethod('POST')
                ->add('type', HiddenType::class, [])
                ->add('companyname', null, [
                    'attr' => ['placeholder' => 'Acme Inc.'],
                ])
                ->add('address', TextareaType::class, [
                    'attr' => ['class' => 'materialize-textarea']
                ])
                ->add('taxnumber')
                ->add('signatureauthorized')
        
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
                ->add('placeofbirth', null, [
                    'label' => 'City of birth'
                ])
//            ->add('country', CountryType::class, [
//                'label' => 'Country of birth',
//            ])
                ->add('country', null, [
                    'label' => 'Country of birth',
                ])
                ->add('phone', null, [
                    'attr' => ['placeholder' => '+49 89 22223333']
                ])
                ->add('email', null, [
                    'attr' => ['placeholder' => 'Email Address']
                ])
                ->add('personalid', null, [
                    'label' => 'Photo of ID'
                ]);
        }
        
        
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
