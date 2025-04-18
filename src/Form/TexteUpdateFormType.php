<?php

namespace App\Form;

use App\Entity\Texte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TexteUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('txt', TextareaType::class,[
                'label' => 'Texte...',
                'attr' => [
                    'placeholder' => 'textes...',
                    'class' => 'FormControl Textarea'
                ],
                'label_attr' => [
                    'class' => 'FormLabel FormLabelTextarea'
                ]
            ])
            ->add('location', TextType::class,[
                'label' => 'Location... (home ou inscription)',
                'attr' => [
                    'placeholder' => 'location...',
                    'class' => 'FormControl'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Modifier',
                'attr' => [
                    'class' => 'GoUpdateTxt'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Texte::class,
        ]);
    }
}
