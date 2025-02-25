<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickName', TextType::class, [
                'label' => 'Nickname :',
                'attr' => [
                    'size' => 30
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'attr' => [
                    'size' => 40
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Legal terms :',
                'constraints' => [
                    new IsTrue([
                        'message' => 'The information collected on this form is stored in an electronic file by CritX 
                        for internal and confidential use at CritX.
                        The legal basis for processing is the performance of a contract, as the information provided is necessary 
                        for the use of the platform and participation in the community. 
                        This includes users\' comments and the potential use of personal data (such as email address and, optionally, 
                        a personal photo) to enable interaction within the platform and improve user experience.
                        Your data will not be shared with third parties without your explicit consent, except where required by law.
                        Consent is obtained when you create an account or when you explicitly opt in for specific features.
                        You have the right to access, rectify, erase, restrict processing of your personal data, 
                        and object to processing or withdraw consent at any time.
                        For any queries or requests regarding your personal data or to exercise your rights, please contact us at admin@critx.com
                        or via our Data Protection Officer at xylo@critx.com. Please refer to our Privacy Policy for more details 
                        on how to exercise your rights.'
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    // new Regex([
                    //     'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*?_-]).{12,}$/',
                    //     'message' => 'Your password must contain at least 12 characters, one lowercase letter, one uppercase letter, one number, and one special character from the following: "!@#$%^&*?_-"'
                    // ])
                ],
                    // new Length([
                    //     'min' => 6,
                    //     'minMessage' => 'Your password should be at least {{ limit }} characters',
                    //     // max length allowed by Symfony for security reasons
                    //     'max' => 4096,
                    // ]),
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords must match',
                'required' => true,
                'first_options' => ['label' => 'Password :', 
                    'attr' => [
                        'size' => 30
                ]],
                'second_options' => ['label' => 'Confirm password :', 
                'attr' => [
                    'size' => 30
                ]],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'tokenCSRF',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
