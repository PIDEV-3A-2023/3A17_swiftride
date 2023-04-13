<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\RegexValidator;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('marque', ChoiceType::class, [
            'choices' => [
                'Audi' => 'Audi',
                'BMW' => 'BMW',
                'Mercedes' => 'Mercedes',
                'Renault' => 'Renault',
                'Peugeot' => 'Peugeot',
            ],
            'placeholder' => 'Donner la marque',
        ])
            ->add('model')
            ->add('matricule', TextType::class, [
                'attr' => [
                    'placeholder' => 'XXX TU XXXX',
                ],
                'label' => 'Matricule',
        'required' => true,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{3}\s[A-Z]{2}\s\d{4}$/',
                        'message' => 'Matricule format is invalid',
                        'match' => true,
                    ]),
                ],
            ])
            ->add('cartegrise')
            ->add('couleur')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Bonne etat' => 'Bonne etat',
                    'En panne' => 'En panne',
                   
                ],
                'placeholder' => 'Donner l"etat',
            ])
            ->add('prix')
            ->add('kilometrage')
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, JPEG, PNG file)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'image/jpeg, image/png',
                ],
            ])
            ->add('position')
            ->add('entrepriseId')
            ;

       
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
