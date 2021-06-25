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
        if (empty($options['data']->getId())) {
            // new occupancy
            $builder
                ->setAction('/inventory/new')
                ->setMethod('POST');
        }
        $builder
            ->add('beds', NULL, [
                'label' => 'inventory.label.beds',
                'attr' => [
                    'placeholder' => 'inventory.label.beds.placeholder'
                ]
            ])
            ->add('closets', NULL, [
                'label' => 'inventory.label.closets',
                'attr' => [
                    'placeholder' => 'inventory.label.closets.placeholder'
                ]
            ])
            ->add('tables', NULL, [
                'label' => 'inventory.label.tables',
                'attr' => [
                    'placeholder' => 'inventory.label.tables.placeholder'
                ]
            ])
            ->add('chairs', NULL, [
                'label' => 'inventory.label.chairs',
                'attr' => [
                    'placeholder' => 'inventory.label.chairs.placeholder'
                ]
            ])
            ->add('floor', NULL, [
                'label' => 'inventory.label.floor',
                'attr' => [
                    'placeholder' => 'inventory.label.floor.placeholder'
                ]
            ])
            ->add('walls', NULL, [
                'label' => 'inventory.label.walls',
                'attr' => [
                    'placeholder' => 'inventory.label.walls.placeholder'
                ]
            ])
            ->add('windows', NULL, [
                'label' => 'inventory.label.windows',
                'attr' => [
                    'placeholder' => 'inventory.label.windows.placeholder'
                ]
            ])
            ->add('doors', NULL, [
                'label' => 'inventory.label.doors',
                'attr' => [
                    'placeholder' => 'inventory.label.doors.placeholder'
                ]
            ])
            ->add('roomsspecial', NULL, [
                'label' => 'inventory.label.roomsspecial',
                'attr' => [
                    'placeholder' => 'inventory.label.roomsspecial.placeholder'
                ]
            ])
            ->add('text', NULL, [
                'label' => 'inventory.label.text',
                'attr' => [
                    'placeholder' => 'inventory.label.text.placeholder'
                ]
            ])
//            ->add('hidden')
//            ->add('deleted')
//            ->add('crdate')
//            ->add('tstamp')
//            ->add('inventory')
//            ->add('booking')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}
