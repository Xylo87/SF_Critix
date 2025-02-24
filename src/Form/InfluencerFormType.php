<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Influencer;
use App\Form\SocialFormType;
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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InfluencerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickName', TextType::class, [
                'label' => 'Nickname :',
                'attr' => [
                    'size' => 35
                ]
            ])
            ->add('realName', TextType::class, [
                'label' => 'Real name :',
                'required' => false,
                'attr' => [
                    'size' => 35
                ]
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio :',
                'attr' => [
                    'rows' => 7,
                    'cols' => 60,
                    'placeholder' => 'Bio may not exceed 300 characters'
                ],
                'constraints' => [
                    new Length([
                        'max' => 300,
                        'maxMessage' => 'Bio may not exceed 300 characters'
                    ])
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo :',
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
            ->add('socials', CollectionType::class, [
                'entry_type' => SocialFormType::class,
                'entry_options' => ['label' => false],
                'label_attr' => [
                    'class' => 'displayFormSocialsLabel'
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
            'data_class' => Influencer::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
