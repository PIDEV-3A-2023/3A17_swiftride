<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntreprisePartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_entreprise', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('nom_admin', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('prenom_admin', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('nb_voiture', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('tel', null, [
            'constraints' => [
                new NotBlank(),
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
            ],
        ])
        ->add('mdp', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('id_admin', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        // Configure your form options here            
        ]);
    }
}
