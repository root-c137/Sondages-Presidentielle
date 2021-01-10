<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Adresse mail',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'adresse mail..'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe ne sont pas identiques",
                "required" => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'mot de passe..'
                    ]
                ],
                'second_options' => [
                    'label' => 'Répetez votre mot de passer',
                    'attr' => [
                            'placeholder' => 'répetez votre mot de passe..'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Inscription',
                'attr' => ['class' => 'GoInscription']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
