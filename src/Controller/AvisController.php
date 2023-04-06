<?php

namespace App\Controller;

use App\Form\AvisType;
use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AvisController extends AbstractController
{

    #[Route('/avis', name: 'app_avis')]
    public function index(): Response
    {
        $Avis = $this->getDoctrine()->getManager()->getRepository(Avis::class)->findAll();
        //$form = $this->createForm(AvisType::class);
        return $this->render('avis/index.html.twig', [
            'a'=>$Avis

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
            $em = $this->getDoctrine()->getManager();
            $em->persist($Avis);//Add
            $em->flush();

            return $this->redirectToRoute('app_avis');
        }
        return $this->render('avis/CreateAvis.html.twig',['f'=>$form->createView()]);



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