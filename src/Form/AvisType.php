<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etoile', ChoiceType::class, [
                'choices' => [
                    'Rate your experience !' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'constraints' => [
                    new NotBlank(),
                    new Range([
                        'min' => 1,
                        'max' => 5,
                        'notInRangeMessage' => 'La note doit être entre 1 et 5',
                    ]),
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ commentaire est obligatoire. Veuillez le remplir']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\s\'\’\-\_\?\!\.,\;\:\(\)]+$/',
                        'message' => 'Le commentaire ne doit pas contenir de caractères spéciaux',
                    ]),
                ],
                'attr' => [
                    'rows' => 5, // Set the number of visible rows
                    'cols' => 40, // Set the number of visible columns
                    'class' => 'form-control' // Add any other classes you want
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
