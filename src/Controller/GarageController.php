<?php

namespace App\Controller;

use App\Form\GarageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GarageController extends AbstractController
{
    #[Route('/garage', name: 'app_garage')]
    public function index(): Response
    {
        $form = $this->createForm(GarageType::class);
        return $this->render('garage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
