<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'app_messages')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
}
