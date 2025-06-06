<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                        // new Regex([
                        //     'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*?_-]).{12,}$/',
                        //     'message' => 'Your password must contain at least 12 characters, one lowercase letter, one uppercase letter, one number, and one special character from the following: "!@#$%^&*?_-"'
                        // ])
                        // new Length([
                        //     'min' => 12,
                        //     'minMessage' => 'Your password should be at least 12 characters',
                        //     // max length allowed by Symfony for security reasons
                        //     'max' => 4096,
                        // ]),
                        // new PasswordStrength(),
                        // new NotCompromisedPassword(),
                    ],
                    'label' => 'New password',
                    'attr' => [
                        'size' => 40
                ]],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'size' => 40
                ]],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
