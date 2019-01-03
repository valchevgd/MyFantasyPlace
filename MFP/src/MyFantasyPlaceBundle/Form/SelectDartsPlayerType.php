<?php

namespace MyFantasyPlaceBundle\Form;

use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectDartsPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('player', EntityType::class, [
            'class' => DartsPlayer::class,
            'query_builder' => function (DartsPlayerRepository $er) {
                return $er->createQueryBuilder('p')
                    ->where("p.status = 'running'");
            },
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
