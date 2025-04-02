<?php

namespace App\Form;

use App\Entity\Social;
use App\Entity\Influencer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SocialFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Title :',
                'attr' => [
                    'size' => 20
                ]
            ])
            ->add('subNumber', TextType::class, [
                'label' => 'Followers number :',
                'attr' => [
                    'size' => 10
                ]
            ])
            ->add('link', UrlType::class, [
                'label' => 'Link :',
                'attr' => [
                    'size' => 60
                ]
            ])
            ->add('channelId', TextType::class, [
                'label' => 'Channel ID :',
                'attr' => [
                    'size' => 30
                ]
            ])
            ->add('liveId', TextType::class, [
                'label' => 'Live ID :',
                'attr' => [
                    'size' => 30
                ]
            ])
            // ->add('influencer', EntityType::class, [
            //     'class' => Influencer::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Social::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
