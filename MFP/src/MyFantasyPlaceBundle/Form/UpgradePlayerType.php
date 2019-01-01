<?php

namespace MyFantasyPlaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpgradePlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tokens', NumberType::class)
            ->add('id', HiddenType::class)
            ->add('upgrade', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

}
