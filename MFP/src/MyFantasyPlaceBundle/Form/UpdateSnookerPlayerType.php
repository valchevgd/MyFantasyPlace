<?php

namespace MyFantasyPlaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateSnookerPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'running' => 'running',
                    'out' => 'out'
                ]
            ])->add('pointsScored', NumberType::class)
            ->add('id', HiddenType::class)
            ->add('breaks', TextType::class, [
                'label' => '50+ Breaks'
            ])
            ->add('Update', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }


}
