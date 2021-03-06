<?php

namespace MyFantasyPlaceBundle\Form;

use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveSnookerPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Players', EntityType::class, [
                'class' => SnookerPlayer::class,
                'choice_label' => 'name',
                'label' => 'Select Players',
                'multiple' => 'true',
                'expanded' => 'true'
            ])
            ->add('Select', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }


}
