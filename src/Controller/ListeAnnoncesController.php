<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Doctrine\Persistence\ManagerRegistry;

class ListeAnnoncesController extends AbstractController
{
    #[Route('/listeannonces', name: 'app_liste_annonces')]
   
    public function listeaccident(ManagerRegistry $doctrine ): Response
    {
       
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();

        return $this->render('annonces/ListeAnnonce.html.twig', [
            'list' => $annonce
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine ,$id ){
        $annonceid =$doctrine->getRepository(Annonces::class)->find($id);
        $em=$doctrine->getManager();
        $em->remove( $annonceid); 
         $em->flush();
         $this->addFlash('notice','succcefully deleted');
         return $this->redirectToRoute('app_homeadmin');
    }
}
