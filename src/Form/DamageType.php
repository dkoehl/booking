<?php

namespace App\Form;

use App\Entity\Damage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DamageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        if(empty($options['data']->getId())){
            $builder->setAction('/damage/new')
                ->setMethod('POST');
        }
        $builder

            ->add('damageart', null, [
                'label' => 'damage.label.damageart',
                'attr' => [
                    'placeholder' => 'damage.label.damageart.placeholder'
                ],
            ])
            ->add('damagetext', null, [
                'label' => 'damage.label.damagetext',
                'attr' => [
                    'placeholder' => 'damage.label.damagetext.placeholder'
                ],
            ])
            ->add('price', null, [
                'label' => 'damage.label.price',
                'attr' => [
                    'placeholder' => 'damage.label.price.placeholder'
                ],
            ])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('crdate')
//            ->add('tstamp')
//            ->add('damage')
//            ->add('booking')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Damage::class,
        ]);
    }
}
