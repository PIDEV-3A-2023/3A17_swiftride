<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Accident;

use App\Entity\Voiture;
use App\Form\AccidentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class ListeAccidentController extends AbstractController
{
    #[Route('/listeaccident', name: 'app_liste_accident')]
  
    public function listeaccident(ManagerRegistry $doctrine ): Response
    {
        $accidents =$doctrine->getRepository(Accident::class)->findAll();
        $voitures =$doctrine->getRepository(Voiture::class)->findAll();

        return $this->render('gestion_accident/ListeAccident.html.twig', [
            'list' => $accidents
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine ,$id){
       
        $accidentid = $doctrine->getRepository(Accident::class)->findOneBy($id);
    
        $em=$doctrine->getManager();
        $em->remove($accidentid); 
        $em->flush();
        $this->addFlash('notice','succcefully deleted');
        return $this->redirectToRoute('app_homeadmin');
    }
    

    
    



}
