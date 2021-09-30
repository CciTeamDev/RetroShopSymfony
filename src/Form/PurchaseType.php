<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Purchase;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('adresse',EntityType::class,[
                'label' => false,
                'required' => true,
                'class' => Adresse::class,
                'multiple' =>false,
                'expanded' =>true,
                'choices' => $user->getAdresses()
            ])
            ->add('carrier',EntityType::class,[
                'label' => 'Choissisez votre transporteur',
                'required' => true,
                'class' => Carrier::class,
                'multiple' =>false,
                'expanded' =>true,
            ])
            ->add('submit',SubmitType::class,[
                'label'=> 'Valider ma commande',
                'attr'=>[
                    'class' => 'btn btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
