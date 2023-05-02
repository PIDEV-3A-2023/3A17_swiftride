<?php

namespace App\Form;

use App\Entity\Accident;

use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\VoitureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
class AccidentType extends AbstractType
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $myEntities = $options['myEntities'];
        $builder
            ->add('type', TextType::class, ['required' => true])
            
            ->add('date',DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d')
                ]
            ])
            ->add('description', TextType::class, ['required' => true])
            ->add('lieu', TextType::class, ['required' => true])
            
            ->add('id_voiture', ChoiceType::class, [
                'choices' => $this->getAvailableVoitures($myEntities), // This should return an array of available voitures
                'expanded' => true, // This makes the field a radio button instead of a dropdown list
                'multiple' => false, // This allows only one voiture to be selected at a time
                
            ])
            
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'gestionaccident',
               
            ])
        ;
    }
    private function getAvailableVoitures($myEntities)
    {
        $choices = [];

        foreach ($myEntities as $entity) {
            $choices[$entity->getMatricule()] = $entity;
        }

        return $choices;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accident::class,
            
        ]);
        $resolver->setRequired('myEntities');
        $resolver->setAllowedTypes('myEntities', 'array');
    }
}
