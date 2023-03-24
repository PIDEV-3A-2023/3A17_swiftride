<?php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AgeCalculation implements EventSubscriberInterface
{   
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    public function preSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();
        $age = $this->calculateAge($form->get('dateNaiss')->getData());
        $form->get('age')->setData($age);
    }

    private function calculateAge(\DateTime $birthdate): int
    {  
        $today = new \DateTime();
        $diff = $today->diff($birthdate);
        return $diff->y;
    }
}