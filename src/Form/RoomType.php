<?php

namespace App\Form;

use App\Entity\Room;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'room.label.name',
                    'attr' => [
                        'placeholder' => 'room.label.name.placeholder'
                    ],
                ]
            )
            ->add('beds', ChoiceType::class, [
                'choices' => [
                    'Please choose' => null,
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
            ])
            ->add('floor', ChoiceType::class, [
                'choices' => [
                    'Please choose' => null,
                    'EG' => 'EG',
                    'OG 1' => 'OG 1',
                    'OG 2' => 'OG 2',
                    'OG 3' => 'OG 3',
                    'OG 4' => 'OG 4',
                ],
            ])
            ->add('house', ChoiceType::class, [
                'choices' => [
                    'Please choose' => null,
                    'Haus Nord' => 'Haus Nord',
                    'Haus Süd' => 'Haus Süd',
                    'Haus Ost' => 'Haus Ost',
                    'Haus West' => 'Haus West',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
