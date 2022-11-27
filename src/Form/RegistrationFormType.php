<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username', TextType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => true,
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe o nome de usuário',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'O nome de usuário de possuir, pelo menos {{ limit }} caracteres.',
                        
                    ]),
                ],
            ]
            )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Você deve concordar com os termos de uso.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe uma senha',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'A senha deve possuir pelo menos {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('confirmedPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, confirme a senha',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'A senha deve possuir pelo menos {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('user_type', CheckboxType::class, [
                'mapped' => false,
                'required' => false,   
                
                
            ])
            ->add('type', HiddenType::class, [
                'mapped' => true,
                'required' => false,       
                
                
            ])
            ->add('cpf', TextType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => true,
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe o CPF',
                    ]),
                    new Length([
                        'min' => 11,
                        'minMessage' => 'CPF inválido',
                        
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
