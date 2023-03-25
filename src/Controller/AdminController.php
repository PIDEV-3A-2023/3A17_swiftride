<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index1.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/login', name: 'login_admin')]
    public function login(): Response
    {
        return $this->render('admin/login.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/listeUser', name: 'liste_admin')]
    public function liste(): Response
    {
        return $this->redirectToRoute('user_liste');
    }
}
