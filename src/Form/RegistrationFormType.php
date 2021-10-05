<?php

namespace App\Form;

use App\Entity\User;
use Faker\Provider\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Form\AdresseType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
              'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
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
              'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
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
              'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
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
            ->add('date_naissance',BirthdayType::class,[
                'label' => 'Date de naissance',
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'label' => 'Veuillez choisir un mot de passe',

                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form_input',
                    'placeholder' => '******'
                ],
                    'label_attr'=>[
                        'class' => 'form_label'
                    ],
                'required' => true,
                'first_options' => ['label' => "Mot de passe"],
                'second_options' => ['label' => "Confirmez votre mot de passe"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
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
