<?php

namespace App\Form;

use App\Entity\User;
use Faker\Provider\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                'label'=>"Nom d'utilisateur",
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'DurantJohn'
                ],
                    'label_attr'=>[
                        'class' => 'form_label'
                ] 
            ])
            ->add('prenom',TextType::class,[
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'John'
                ],
                    'label_attr'=>[
                        'class' => 'form_label'
                ] 
            ])
            ->add('nom',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Durant'
                ],
                    'label_attr'=>[
                        'class' => 'form_label'
                ] 
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60]),
                'attr' =>[
                    'class' => 'form_input',
                    'placeholder' => 'DurantJohn@mail.com'
                ],
                    'label_attr'=>[
                        'class' => 'form_label'
                ] 
            ])
            ->add('genre', ChoiceType::class,
                [
                    'label'    => 'Genre',
                    'row_attr' => ['class' => 'form_choices'],
                    'label_attr' =>['class'=> 'form_label'],
                    'choices'  =>
                        [
                            'Homme' => 'Homme',
                            'Femme'  => 'Femme',
                            'Autre'  => 'Autre',
                        ],
                    'expanded' => true,
                    'multiple' => false
                ]
            )
            ->add('date_naissance',DateTimeType::class,[
                'label' => 'Date de naissance',
                'label_attr' =>['class'=> 'form_label'],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Veuillez choisir un mot de passe',
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form_input',
                    'placeholder' => '******'
                ],
                    'label_attr'=>[
                        'class' => 'form_label'
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "Conditions d'utilisation",
                'label_attr' =>['class'=> 'form_label'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter nos conditions d utilisation',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
