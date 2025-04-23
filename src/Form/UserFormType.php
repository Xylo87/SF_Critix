<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Critic;
use App\Entity\Influencer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profilePicture', FileType::class, [
                'label' => 'Profile picture',
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
            ->add('status', TextType::class, [
                'label' => 'Mood',
                'attr' => [
                    'size' => 60,
                    'placeholder' => 'Status may not exceed 75 characters'
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 75,
                        'maxMessage' => 'Status may not exceed 75 characters'
                    ])
                ]
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio',
                'attr' => [
                    'rows' => 5,
                    'cols' => 40,
                    'placeholder' => 'Bio may not exceed 220 characters'
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 220,
                        'maxMessage' => 'Bio may not exceed 220 characters'
                    ])
                ]
            ])
            ->add('validate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item'
        ]);
    }
}
