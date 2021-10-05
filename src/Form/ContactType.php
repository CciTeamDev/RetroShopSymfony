<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'John',
                    'value' => $options['user'] instanceof User ? $options['user']->getPrenom() : '',
                    'disabled'=>$options['user'] instanceof User ? true : false
                ],
                'label_attr'=>[
                    'class' => 'form_label'
                ]               
            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Durant',
                    'value' => $options['user'] instanceof User ? $options['user']->getNom() : '',
                    'disabled'=>$options['user'] instanceof User ? true : false
                ],
                'label_attr'=>[
                    'class' => 'form_label'
                ]    
                
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'JohnDurant@mail.com', 
                    'value' => $options['user'] instanceof User ? $options['user']->getEmail() : '',
                    'disabled'=>$options['user'] instanceof User ? true : false
                ],
                'label_attr'=>[
                    'class' => 'form_label'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => [
                    'class' => 'form_input form_message',
                    'placeholder' => 'En quoi pouvons-nous vous aider ?'
                ],
                'label_attr'=>[
                    'class' => 'form_label'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary rounded-pill form_button'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => null
        ]);
    }
}
