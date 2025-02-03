<?php

namespace App\Form;

use App\Entity\User;
use App\Form\FormExtension\HoneyPotType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

// Extends HoneyPotType pour étendre de la classe HoneyPotType avec les champs cachés 'phone' et 'faxNumber' et l'event subscriber pour surveiller les formulaires
class RegistrationFormType extends HoneyPotType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Appel de la fonction buildForm de la classe parent pour construire les champs du formulaire
        parent::buildForm($builder, $options);

        // Ajout des champs 'name', 'email', 'plainPassword' et 'agreeTerms' au formulaire
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Name'
                ],
                'label' => false,
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'placeholder' => 'Email'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email',
                    ]),
                ],
                'label' => false,
                'required' => true
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Password'
                    ],
                    'label' => false,
                    'required' => true
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Repeat Password'
                    ],
                    'label' => false,
                    'required' => true
                ],
                'invalid_message' => 'The password fields must match.',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                        'message' => 'Votre mot de passe doit contenir au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.'
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'register',
            'csrf_header_name' => 'X-CSRF-TOKEN',
        ]);
    }
}
