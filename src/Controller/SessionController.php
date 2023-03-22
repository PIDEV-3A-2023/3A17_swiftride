<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
    public function startSession($id,$email)
    {
        $this->session->start();
        $this->session->set('user_id', $id);
        $this->session->set('user_email', $email);
        
        return $this->redirectToRoute('homepage');
    }
    public function endSession(){
        $this->session->invalidate();
    }
    public function getUserData()
    {
        $userId =  $this->session->get('user_id');
        $userEmail =  $this->session->get('user_email');
        $user=new Utilisateur();
        $user->setId($userId);
        $user->setLogin($userEmail);
        return $user;
        
    }
}
