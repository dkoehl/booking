<?php

namespace App\Form;

use App\Entity\Inventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beds')
            ->add('closets')
            ->add('tables')
            ->add('chairs')
            ->add('floor')
            ->add('walls')
            ->add('windows')
            ->add('doors')
            ->add('roomsspecial')
            ->add('hidden')
            ->add('deleted')
            ->add('crdate')
            ->add('tstamp')
            ->add('text')
            ->add('inventory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}
