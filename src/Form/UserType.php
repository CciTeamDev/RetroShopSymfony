<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                'label'=>'Veuillez choisir un nom d utilisateur',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ])
            ])
            ->add('prenom',TextType::class,[
                'label' => 'Veuillez rentrer votre prénom',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
            ])
            ->add('nom',TextType::class,[
                'label' => 'Veuillez rentrer votre nom',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60]),
                'attr' =>[
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])
            ->add('genre', ChoiceType::class,
                array(
                    'label'     => 'Genre',
                    'choices'  =>
                        array(
                            'Homme' => 'Homme',
                            'Femme'  => 'Femme',
                            'Autre'  => 'Autre',
                        ),
                    'expanded' => true,
                    'multiple' => false
                )
            )
            ->add('date_naissance',BirthdayType::class,[
                'label' => 'Date de naissance',
            ])
            ->add('old_password',PasswordType::class,[
                'label' => 'Mon mot de passe actuel',
                'mapped'=>false,
                'attr' =>[
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password',RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passe et la confirmation doivent etre identiques',
                'label' => 'Mon nouveau mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => "Mon nouveau mot de passe",
                    'attr' => [
                        'placeholder ' => "Merci de saisir votre nouveau mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => "Confirmez votre mot de passe",
                    'attr' => [
                        'placeholder ' => "Merci de confirmer votre nouveau mot de passe"
                    ]

                ]
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
