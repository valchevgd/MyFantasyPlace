<?php

namespace MyFantasyPlaceBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
            ->add('startingDate', DateType::class, [
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'widget' => 'single_text'

            ])
            ->add('Add', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

}
