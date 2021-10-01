<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entre votre nom'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Votre société',
                'required' => false,
                'attr' => [
                    'placeholder' => '(facultatif) Entrez le nom de votre société'
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => '8 rue des lylas ...'
                ]
            ])
            ->add('cp', TextType::class, [
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => 'Entrez votre code postal'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entrez votre ville'
                ]
            ])
            ->add('pays', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'Votre pays'
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => 'Entrez votre téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
