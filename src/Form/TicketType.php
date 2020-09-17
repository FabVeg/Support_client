<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priority', ChoiceType::class, [
                'label'     => 'Priorité',
                'multiple'  => false, 
                'expanded'  => false, 
                'choices'   => [
                    'HAUTE'     =>  'HAUTE',
                    'NORMALE'   =>  'NORMALE',
                    'BASSE'     =>  'BASSE',
                ],
            ])
            ->add('title', null, [
                'label' => 'Titre'
            ])
            ->add('description',TextareaType::class,[
                'attr' => [
                    'rows' => 8
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
