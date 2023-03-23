<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
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
            ->add('numTel')
            ->add('login')
            ->add('mdp',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
