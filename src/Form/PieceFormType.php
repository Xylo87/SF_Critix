<?php

namespace App\Form;

use App\Entity\Piece;
use App\Entity\Category;
use App\Form\ImageFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PieceFormType extends AbstractType
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
            ->add('about', TextareaType::class, [
                'label' => 'About :',
                'attr' => [
                    'rows' => 8,
                    'cols' => 60,
                    'placeholder' => 'Description may not exceed 360 characters'
                ],
                'constraints' => [
                    new Length([
                        'max' => 360,
                        'maxMessage' => 'Description may not exceed 360 characters'
                    ])
                ]
            ])
            ->add('maker', TextType::class, [
                'label' => 'Maker :',
                'attr' => [
                    'size' => 35
                ]
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Release Date :'
            ])
            ->add('isUpcoming', CheckboxType::class, [
                'label' => 'Upcoming ? :',
                'required' => false,
            ])
            ->add('poster', FileType::class, [
                'label' => 'Poster :',
                'mapped' => false,
                'required' => false,
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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Category :'
                // 'choice_label' => 'id'
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageFormType::class,
                'entry_options' => ['label' => false],
                'label_attr' => [
                    'class' => 'displayFormImagesLabel'
                ],
                'required' => false,
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoFormType::class,
                'entry_options' => ['label' => false],
                'label_attr' => [
                    'class' => 'displayFormVideosLabel'
                ],
                'required' => false,
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('validate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
