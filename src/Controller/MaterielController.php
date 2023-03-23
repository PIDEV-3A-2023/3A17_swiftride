<?php

namespace App\Controller;

use App\Form\MaterielType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterielController extends AbstractController
{
    #[Route('/materiel', name: 'app_materiel')]
    public function index(): Response
    {
        $form=$this->createForm(MaterielType::class);
        return $this->render('materiel/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
