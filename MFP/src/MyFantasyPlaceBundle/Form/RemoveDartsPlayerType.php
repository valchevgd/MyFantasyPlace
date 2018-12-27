<?php

namespace MyFantasyPlaceBundle\Form;

use MyFantasyPlaceBundle\Entity\DartsPlayer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveDartsPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Players', EntityType::class, [
            'class' => DartsPlayer::class,
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
