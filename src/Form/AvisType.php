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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('etoile', HiddenType::class, [
            'label' => 'Note',
            'attr' => [
                'id' => 'rating_input',
                'required' => 'required',
                'name' => 'etoile', // add this line
            ]
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
                    'class' => 'form-control', // Add any other classes you want
                    'placeholder' => 'Partager votre expérience avec SWIFT RIDE' // Add the placeholder text
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