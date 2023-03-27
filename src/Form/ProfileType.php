<?php

namespace App\Form;

use App\Entity\Utilisateur;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
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
            ->add('photo_personel',HiddenType::class)
            ->add('photo_permis',HiddenType::class)
            ->add('num_tel')
            ->add('login' ,EmailType::class)
            ->add('mdp',PasswordType::class)
            ->add('newmdp',PasswordType::class, [
                'mapped' => false,
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Ce champs est vide'
                    ]),
                    new NotNull([
                        'message'=>'Ce champs est vide'
                    ]),
                    new Length([
                        'min'=>6,
                        'max'=>20,
                        'minMessage'=>'contient 6 caractéres au minimum',
                        'maxMessage'=>'contient 20 caractéres au maximum'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Enregistrer'
            ]);
            
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
