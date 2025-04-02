<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Piece;
use App\Entity\Critic;
use App\Entity\Influencer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CriticFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('media', TextType::class, [
                'label' => 'Link :',
                'attr' => [
                    'size' => 30
                ]
            ])
            ->add('summary', TextareaType::class, [
                'label' => "Summary :",
                'attr' => [
                    'placeholder' => 'Summary may not exceed 150 characters',
                    'rows' => 4,
                    'cols' => 35
                ],
                'constraints' => [
                    new Length([
                        'max' => 150,
                        'maxMessage' => 'Summary may not exceed 150 characters'
                    ])
                ]
            ])
            ->add('criticScore', NumberType::class, [
                'label' => "Critic Score :",
                'html5' => true,
                'scale' => 1,
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 0.5
                ],
                'constraints' => [
                    new Range([
                        'min' => 0,
                        'max' => 5,
                        'notInRangeMessage' => 'Critic Score must be set between 0 & 5'
                    ]),
                ]
            ])
            ->add('lengthMin', IntegerType::class, [
                'label' => "Length in minutes :",
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('originDatePost', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Original post date :'
            ])
            ->add('piece', EntityType::class, [
                'class' => Piece::class,
                'label' => 'Piece :'
            ])
            ->add('influencer', EntityType::class, [
                'class' => Influencer::class,
                'label' => 'Influencer :'
            ])
            // ->add('users', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            ->add('validate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Critic::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
