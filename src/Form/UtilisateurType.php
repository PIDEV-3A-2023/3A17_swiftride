<?php

namespace App\Form;

use AgeCalculation;
use App\Entity\Role;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Range;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('cin')
            ->add('date_naiss', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints'=>[
                    new Range([
                        'min' => new \DateTime('-18 years'),
                        'minMessage' => 'vous devez avoir au minimum 18 ans ',
                    ]),
                ]
              /*  'invalid_range' => [
                    'start' => '-18 years',
                    'end' => 'today',
                ],*/
                // this is actually the default format for single_text
            ])
            ->add('num_permis')
            ->add('ville',ChoiceType::class,[
                'choices'=>[
                    "Ariana"=>"Ariana",
                    "Beja"=>"Beja",
                    "Ben Arous"=>"Ben Arous",
                    "Bizerte"=>"Bizerte",
                    "Gabes"=>"Gabes",
                    "Gafsa"=>"Gafsa",
                    "Jendouba"=>"Jendouba",
                    "Kairouan"=>"Kairouan",
                    "Kasserine"=>"Kasserine",
                    "Kebili"=>"Kebili",
                    "Kef"=>"Kef",
                    "Mahdia"=>"Mahdia",
                    "Manouba"=>"Manouba",
                    "Medenine"=>"Medenine",
                    "Monastir"=>"Monastir",
                    "Nabeul"=>"Nabeul",
                    "Sfax"=>"Sfax",
                    "Sidi Bou Zid"=>"Sidi Bou Zid",
                    "Siliana"=>"Siliana",
                    "Sousse"=>"Sousse",
                    "Tataouine"=>"Tataouine",
                    "Tozeur"=>"Tozeur",
                    "Tunis"=>"Tunis",
                    "Zaghouan"=>"Zaghouan",
                ]
            ])
            ->add('num_tel')
            ->add('login', EmailType::class)
            ->add('mdp', PasswordType::class)
            ->add('photo_personel',FileType::class,[ 'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image',
                ])]])
            ->add('photo_permis',FileType::class,[
                'label' => 'Choisi une photo de permis',
             'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image',
                ])]])
            
            ->add('submit', SubmitType::class,[
                'label'=>'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
          
        ]);
    }
}
