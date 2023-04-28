<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Accident;
use Carlosmg89\CaptchaBundle\Validator\Constraints as CaptchaAssert;
use App\Entity\Voiture;
use App\Form\AccidentType;
use App\Form\UpdateaccidentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GestionAccidentController extends AbstractController
{
    #[Route('/gestionaccident', name: 'app_gestion_accident')]
    
public function createaccident(ManagerRegistry $doctrine , Request $req, ValidatorInterface $validator): Response
    {
        $accident =$doctrine->getRepository(Accident::class)->findAll();
        // retrieve the latest accidents
$accidents =$doctrine->getRepository(Accident::class)->findBy([], ['date' => 'DESC'], 5);


        $accident=new Accident();
$idvoiture =$doctrine->getRepository(Voiture::class)->findAvailableVoituresQueryBuilder();
        $form = $this->createForm(AccidentType::class, $accident, ['myEntities' => $idvoiture]);

        
        $form->handleRequest($req);

        $em=$doctrine->getManager();
       

        if ($form->isSubmitted() && $form->isValid()) {
            $recaptchaResponse = $req->get('g-recaptcha-response');
            $violations = $validator->validate($recaptchaResponse, [
                new Recaptcha3([
                    'message' => 'Please confirm that you are not a robot'
                ])
            ]);
            
            
                // Handle validation success
                $em = $doctrine->getManager();
                $em->persist($accident);
                $em->flush();
                return $this->redirectToRoute('app_homeadmin');
            
        }
        return $this->render('gestion_accident/index.html.twig', [
            'form'=>$form->createView(),
            'accident'=>$accident,
            'message' => 'Thank you, you have been verified as a human and are not a robot',
           

            
        ]);
       
    }

    
    #[Route('gestionaccident/update/{id}', name: 'update')]
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