<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Maintenance;
use App\Entity\Voiture;
use App\Form\MaintenanceType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(ManagerRegistry $doctrine , Request $req): Response
    {
        
        $garages=$doctrine->getRepository(Garage::class)->findAll();
        $voiture =$doctrine->getRepository(Voiture::class)->findAll();
        $maintenances = $doctrine->getRepository(Maintenance::class)->findAll();

        $maintenance=new Maintenance();

        $form=$this->createForm(MaintenanceType::class,$maintenance, [
            'myEntities' => $garages,
            'voiture'=>$voiture
        ]);

        
        $form->handleRequest($req);

        $em=$doctrine->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($maintenance);

            $em->flush();

            return $this->redirectToRoute('app_garage');

        }

        return $this->render('maintenance/index.html.twig', [
            'form'=>$form->createView(),
            'maintenances'=>$maintenances
        ]);
    }

}
