<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Type;

class UpdateUserFormType extends AbstractType
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
                ],
            ])
            ->add('datenaissance', IntegerType::class, [
                'label' => 'Age',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'votre age..'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ],
                'constraints' => array( new Type('integer') )
            ])
            ->add('codepostal', IntegerType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'code postal..'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ],
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Modifier',
                'attr' => ['class' => 'GoModifier']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
