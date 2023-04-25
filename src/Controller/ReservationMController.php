<?php

namespace App\Controller;

use App\Repository\ReservationMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ReservationM;
use App\Form\ReservationMType;

class ReservationMController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation_m')]
    public function index(ReservationMRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('reservation_m/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

     /**
     * @Route("/addreservation", name="addReservation")
     */

     public function addReservation(Request $request): Response
     {
         $ReservationM = new ReservationM();
         $form = $this->createForm(ReservationMType::class, $ReservationM);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($ReservationM);//Add
             $em->flush();
 
             return $this->redirectToRoute('app_reservation_m');
         }
         return $this->render('reservation_m/createReservationM.html.twig',['form'=>$form->createView()]);
 
     }
}
