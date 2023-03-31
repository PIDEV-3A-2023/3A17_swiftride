<?php

namespace App\Form;

use App\Entity\Maintenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $myEntities = $options['myEntities'];
        $voiture =$options['voiture'];
        $builder
            ->add('dateMaintenance',DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d')
                ]
            ])
            ->add('finMaintenance',DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d')
                ]
            ])
            ->add('type', ChoiceType::class,[
                'choices'=>[
                    'Entretient'=>'entretient',
                    'Maintenance'=>'maintenace'
                ],
                'expanded' => true,
            ])
            ->add('idVoiture' , ChoiceType::class, [
                'choices'=>$this->getDropdownListChoicess( $voiture)
                ])
            ->add('idGarage' , ChoiceType::class,[
                
                'choices'=>$this->getDropdownListChoices($myEntities)
            ])
            ->add('ajouter',SubmitType::class)
        ;
    }

    private function getDropdownListChoices($myEntities)
    {
        $choices = [];

        foreach ($myEntities as $entity) {
            $choices[$entity->getMatriculeGarage()] = $entity;
        }

        return $choices;
    }

    private function getDropdownListChoicess($myEntities)
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
            'data_class' => Maintenance::class,
            'cascade_validation' => true
        ]);

        $resolver->setRequired('myEntities');
        $resolver->setRequired('voiture');
        $resolver->setAllowedTypes('voiture', 'array');
        $resolver->setAllowedTypes('myEntities', 'array');
    }
}
