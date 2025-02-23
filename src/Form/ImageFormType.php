<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Piece;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title :',
                'attr' => [
                    'size' => 35
                ]
            ])
            ->add('link', FileType::class, [
                'label' => 'Image :',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/png',
                        'image/jpeg',
                        'image/jpg',
                        'image/gif',
                        'image/webp',
                        'image/avif'
                        ],
                        'mimeTypesMessage' => 'Please upload an image with a valid format (png, jpeg, jpg, gif, webp, avif)'
                    ])
                ]
            ])
            ->add('isPoster', CheckboxType::class, [
                'label' => 'Poster ? :'
            ])
            // ->add('piece', EntityType::class, [
            //     'class' => Piece::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
