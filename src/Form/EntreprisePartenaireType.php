<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Email;


class EntreprisePartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_entreprise', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le nom d\'entreprise doit être alphabétique'
                ]),
            ],
        ])
        ->add('nom_admin', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le nom d\'admin doit être alphabétique'
                ]),
            ],
        ])
        ->add('prenom_admin', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le prénom d\'admin doit être alphabétique'
                ]),
            ],
        ])
        ->add('nb_voiture', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[1-9]\d*$/',
                    'message' => 'Le nombre de voitures doit être un nombre supérieur à 0'
                ]),
            ],
        ])
        ->add('tel', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^\d{8}$/',
                    'message' => 'Le numéro de téléphone doit contenir exactement 8 chiffres'
                ]),
            ],
        ])
        
        ->add('matricule', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('login', null, [
            'constraints' => [
                new NotBlank(),
                new Email([
                    'message' => 'Le champ doit contenir une adresse email valide'
                ]),
            ],
        ])
        ->add('mdp', PasswordType::class, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                    'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et de longeur 8 caracteres'
                ])
            ],
            'attr' => [
                'autocomplete' => 'new-password', // to prevent browser autocomplete on password
                'class' => 'form-control', // add any custom classes you want
                'type' => 'password', // set the type of the input as password
                'placeholder' => 'Enter your password', // add a placeholder text
                'data-toggle' => 'password' // add a data-toggle attribute for showing/hiding password
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