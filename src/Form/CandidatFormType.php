<?php

namespace App\Form;

use App\Entity\Candidat;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'Prénom'
                ],
                'label_attr' => [
                    'class' => 'FormLabel',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'Nom'
                ],
                'label_attr' => [
                    'class' => 'FormLabel',
                ]
            ])
            ->add('age', TextType::class, [
                'label' => 'Age',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'Age'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ]
            ])
            ->add('parti', TextType::class, [
                'label' => 'Parti politique',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'parti politique'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ]
            ])
            ->add('wiki', TextType::class, [
                'label' => 'Wiki',
                'attr' => [
                    'class' => 'FormControl',
                    'placeholder' => 'lien wikipédia..'
                ],
                'label_attr' => [
                    'class' => 'FormLabel'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'GoAddCandidat'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);

    }
}
