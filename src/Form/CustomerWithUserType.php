<?php

namespace App\Form;

use App\Form\CustomerType;
use App\Form\UserRegisterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerWithUserType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', CustomerType::class, [
                'label' => false
            ])
            ->add('user', UserRegisterType::class, [
                'label' => false
            ])
            // On enleve les champs password et roles de l'utilisateur 
            // (il sera généré via le controller)
            ->get('user')
                ->remove('password')
                ->remove('roles')
        ;
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => 'register'
        ]);
    }
}
