<?php

namespace App\Form;

use App\Entity\Piece;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
                    'cols' => 60
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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Category :'
                // 'choice_label' => 'id',
            ])
            ->add('validate', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
