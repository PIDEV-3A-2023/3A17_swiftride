<?php

namespace App\Controller;

use App\Form\MaintenanceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(): Response
    {
        $form=$this->createForm(MaintenanceType::class);
        return $this->render('maintenance/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
