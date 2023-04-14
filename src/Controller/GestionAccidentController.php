<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Accident;

use App\Entity\Voiture;
use App\Form\AccidentType;
use App\Form\UpdateaccidentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
class GestionAccidentController extends AbstractController
{
    #[Route('/gestionaccident', name: 'app_gestion_accident')]
    
public function createaccident(ManagerRegistry $doctrine , Request $req): Response
    {
        $accident =$doctrine->getRepository(Accident::class)->findAll();
        // retrieve the latest accidents
$accidents =$doctrine->getRepository(Accident::class)->findBy([], ['date' => 'DESC'], 5);


        $accident=new Accident();
$idvoiture =$doctrine->getRepository(Voiture::class)->findAvailableVoituresQueryBuilder();
        $form = $this->createForm(AccidentType::class, $accident, ['myEntities' => $idvoiture]);

        
        $form->handleRequest($req);

        $em=$doctrine->getManager();
       

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($accident);

            $em->flush();

            return $this->redirectToRoute('app_homeadmin');

        }

        return $this->render('gestion_accident/index.html.twig', [
            'form'=>$form->createView(),
            'accident'=>$accident

            
        ]);
    }

    
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, $id)
    {
        $accident = $doctrine->getRepository(Accident::class)->find($id);
        $form = $this->createForm(UpdateaccidentType::class, $accident);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $this->addFlash('success', 'Accident updated successfully!');
            return $this->redirectToRoute('app_liste_accident');
        }
    
        return $this->render('gestion_accident/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
}