<?php

namespace App\Controller;

use App\Form\AvisType;
use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;



class AvisController extends AbstractController
{

    #[Route('/avis', name: 'app_avis')]
    public function index(): Response
    {
        $Avis = $this->getDoctrine()->getManager()->getRepository(Avis::class)->findAll();
        //$form = $this->createForm(AvisType::class);

// récupérer tous les avis
$avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();
    
// calculer le nombre total d'avis
$totalAvis = count($avis);
 
// calculer la moyenne d'avis
$moyenneAvis = 0;
if ($totalAvis > 0) {
    $sum = 0;
    foreach ($avis as $a) {
        $sum += $a->getEtoile();
    }
    $moyenneAvis = round($sum / $totalAvis, 1);
}

// trouver l'avis ayant 5 étoiles et le plus long
$avis5etoilesLePlusLong = null;
$longueurMax = 0;
foreach ($avis as $a) {
    if ($a->getEtoile() == 5) {
        $longueur = strlen($a->getCommentaire());
        if ($longueur > $longueurMax) {
            $longueurMax = $longueur;
            $avis5etoilesLePlusLong = $a;
        }
    }
}

return $this->render('avis/index.html.twig', [
    'a' => $avis,
    'totalAvis' => $totalAvis,
    'moyenneAvis' => $moyenneAvis,
    'avis5etoilesLePlusLong' => $avis5etoilesLePlusLong,
]);


    }
   
    /**
     * @Route("/addavis", name="addAvis")
     */

     public function addAvis(Request $request): Response
     {
         $Avis = new Avis();
         $form = $this->createForm(AvisType::class, $Avis);
         $form->handleRequest($request);
         
         if($form->isSubmitted() && $form->isValid()) {
            $etoile = $request->request->get('etoile');

            
            if ($etoile === null) {
                // set a default value
                $etoile = 0;
                // or throw an exception
                throw new Exception('Etoile field cannot be null.');
            }
             
             $Avis->setEtoile($etoile);
                   
             $em = $this->getDoctrine()->getManager();
             $em->persist($Avis);//Add
             $em->flush();
             
             return $this->redirectToRoute('app_avis');
         }
         
         return $this->render('avis/createAvis.html.twig',['f'=>$form->createView()]);
     }
     
     
    #[Route('/removeAvis/{id}', name: 'supavis')]
    public function suppressionAvis(Avis $Avis): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($Avis);
        $em->flush();
        
        
        //return$this->redirectToRoute('supavis');
        return $this->redirectToRoute('app_avis', ['id' => $Avis->getId()]);


    }


    #[Route('/modifavis/{id}', name: 'modifAvis')]
     public function modifAvis(Request $request,$id): Response
     {
         $Avis = $this->getDoctrine()->getManager()->getRepository(Avis::class)->find($id);
         $form = $this->createForm(AvisType::class, $Avis);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->flush();
 
             return $this->redirectToRoute('app_avis'); 
         }
         return $this->render('Avis/updateAvis.html.twig',['f'=>$form->createView()]);
     }

    } 