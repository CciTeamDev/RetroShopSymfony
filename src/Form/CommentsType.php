<?php

namespace App\Form;

use App\Entity\Comments;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceValue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\ChoiceValidator;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', ChoiceType::class, [
                "label" => "Votre note :",
                'choices' => [
                    "Très mauvais" => "Très mauvais",
                    "Mauvais" => "Mauvais",
                    "Bon" => "Bon",
                    "Très bon" => "Très bon",
                    "Excellent" => "Excellent"
                ]
            ])
            ->add('content', TextType::class, [
                "label" => "Votre commentaire :"
            ])
            ->add('envoyer', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
