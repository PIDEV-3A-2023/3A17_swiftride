<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index2.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/login', name: 'login_admin')]
    function login(AuthenticationUtils $authenticationUtils): Response
        {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('admin/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route('/listeUser', name: 'liste_admin')]
    public function liste(UtilisateurRepository $utilisateurRepository, RoleRepository $roleRepository): Response
    {
    return $this->render('admin/datatable.html.twig', [
        'utilisateurs' => $utilisateurRepository->findByRoleId($roleRepository->find(2)),
    ]);
}
}
