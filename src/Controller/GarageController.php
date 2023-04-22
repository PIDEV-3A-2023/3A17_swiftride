<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Materiel;
use App\Form\GarageType;
use App\Form\MaterielType;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GarageController extends AbstractController
{
    #[Route('/garage', name: 'app_garage')]
    public function index(ManagerRegistry $doctrine , Request $req): Response
    {
        $em=$doctrine->getManager();
        $garage = new Garage();

        $form = $this->createForm(GarageType::class , $garage);
        $forms = $this->createForm(GarageType::class);
        
        $form->handleRequest($req);

        $garages=$doctrine->getRepository(Garage::class)->findAll();

        if($form->isSubmitted() && $form->isValid()){

            $doctrine->getRepository(Garage::class)->save($garage,true);

            return  $this->redirectToRoute('materiel_g',['id'=>$garage->getId()]);
        }
        return $this->render('garage/index.html.twig', [
            'form' => $form->createView(),
            'forms' => $forms->createView(),
            'garages'=>$garages
        ]);
    }


    #[Route('/deleteGarage/{id}', name:'app_deleteg')]
    public function deleteGarage($id , ManagerRegistry $mngr){

        $garage = $mngr->getRepository(Garage::class)->find($id);

        $em=$mngr->getManager();

        $em->remove($garage);

        $em->flush();

        return $this->redirectToRoute('app_garage');

    }

   #[Route('/updateGarage/{id}', name:'app_updateg')]
    public function udpateGarage($id , ManagerRegistry $mngr , Request $req) : Response
    {
        $garage = $mngr->getRepository(Garage::class)->find($id);

        $form=$this->createForm(GarageType::class,$garage);
        $form->handleRequest($req);


        if($form->isSubmitted() && $form->isValid()){
            $em = $mngr->getManager();
            $em->flush();

            return $this->redirectToRoute('app_garage');
        }

        return $this->render('garage/updateGarage.html.twig', [
            'form' => $form->createView(),
            'g'=>$garage
        ]);
       
    }

    #[Route('/', name:'app_main')]
    public function indexx(){

        return $this->render('base.html.twig');
    }


}
