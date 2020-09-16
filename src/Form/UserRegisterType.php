<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = [
            'ROLE_ADMIN'            => 'ROLE_ADMIN'
        ];
 
        if($options['type_register'] == 'sub_account') {
            $roles = [
                'ROLE_CUSTOMER'         => 'ROLE_CUSTOMER',
                'ROLE_CUSTOMER_ADMIN'   => 'ROLE_CUSTOMER_ADMIN',
            ];
        }
 
        $builder
            ->add('email')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true, 
                'expanded' => true, 
                'choices' => $roles,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    => User::class,
            'type_register' => 'account'
        ]);
    }
}


