<?php

namespace MyFantasyPlaceBundle\Form;

use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectSnookerPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('snookerPlayer', EntityType::class, [
            'class' => SnookerPlayer::class,
            'choice_label' => 'name',
            'label' => 'Select Player To Update',
            'placeholder' => ''
        ])
            ->add('Update This Player', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

}
