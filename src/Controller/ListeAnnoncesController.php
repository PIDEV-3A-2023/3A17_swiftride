<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidSimpleCaptchaValidator;


use Doctrine\Persistence\ManagerRegistry;

class ListeAnnoncesController extends AbstractController
{
    #[Route('/listeannonces', name: 'app_liste_annonces')]
   
    public function listeaccident(ManagerRegistry $doctrine ,PaginatorInterface $paginator, Request $request ): Response
    {
       
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();
        $query =$doctrine->getRepository(Annonces::class)->findAll();
 
        $pager = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('annonces/ListeAnnonce.html.twig', [
            'list' => $annonce,
            'pager' => $pager,

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
