<?php

namespace MyFantasyPlaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateDartsPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'null' => null,
                    'running' => 'running',
                    'out' => 'out'
                ]
            ])->add('overHundred', NumberType::class)
            ->add('id', HiddenType::class)
            ->add('overOneHundredAndForty', NumberType::class)
            ->add('maximums', NumberType::class)
            ->add('checkoutPercentage', NumberType::class)
            ->add('averageThreeDarts', NumberType::class)
            ->add('Update', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

}
