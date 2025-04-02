<?php

namespace App\Form;

use App\Entity\Piece;
use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class VideoFormType extends AbstractType
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
            ->add('link', TextType::class, [
                'label' => 'Link :',
                'attr' => [
                    'size' => 30
                ]
            ])
            ->add('isTrailer', CheckboxType::class, [
                'label' => 'Trailer ? :'
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
            'data_class' => Video::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
