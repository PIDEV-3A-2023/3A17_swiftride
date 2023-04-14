<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class HomePageController extends AbstractController
{
    #[Route('/homepage', name: 'app_home_page')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();

        return $this->render('home_page/index.html.twig', [
            'list' => $annonce
        ]);
    }
}
