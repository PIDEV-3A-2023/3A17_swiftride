<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Accident;
use Doctrine\Persistence\ManagerRegistry;

class HomeAdminController extends AbstractController
{
    #[Route('/homeadmin', name: 'app_homeadmin')]
    
    public function notificationaccident(ManagerRegistry $doctrine ): Response{
    // retrieve the latest accidents
$accidents = $doctrine->getRepository(Accident::class)->findBy([], ['date' => 'DESC'], 5);

return $this->render('home_admin/index.html.twig', [
    'accidents' => $accidents,
]);
}
}