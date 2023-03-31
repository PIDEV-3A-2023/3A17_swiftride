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


    #[Route('/deleteMaintenence/{id}', name: 'delete_maintenance')]
    public function deleteMaintenance($id,ManagerRegistry $doctrine)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        return $this->redirectToRoute('app_maintenance');
    }

    #[Route('/updateMaintenance/{id}', name: 'update_maintenance')]
    public function updateMaintenance($id , ManagerRegistry $doctrine , Request $req)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        
        $garages=$doctrine->getRepository(Garage::class)->findAll();
        $voiture =$doctrine->getRepository(Voiture::class)->findAll();

        $form=$this->createForm(MaintenanceType::class,$maintenance, [
            'myEntities' => $garages,
            'voiture'=>$voiture
        ]);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('app_maintenance');

        }

        return $this->render('maintenance/updateMaintenance.html.twig', [
            'form'=>$form->createView(),
            'm'=>$maintenance
        ]);

    }

}
