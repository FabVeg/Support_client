<?php

namespace App\Form;

use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File as SymfonyFile;
use Symfony\Component\Form\Extension\Core\Type\FileType as SymfonyFileType;


class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('size')
            ->add('path')
            ->add('ticket')
            ->add('message')
            ->add('photo', SymfonyFileType::class, [
                'mapped' => false,
                'constraints' => [
                    new SymfonyFile([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Le format est incorrect.',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
