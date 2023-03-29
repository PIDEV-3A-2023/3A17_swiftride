<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Form\UpdateMaterielType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterielController extends AbstractController
{
    #[Route('/materiel', name: 'app_materiel')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repg = $doctrine->getRepository(Garage::class);
        $repm=$doctrine->getRepository(Materiel::class);

        $materiels=$repm->findAll();
        $garages=$repg->findAll();
        return $this->render('materiel/index.html.twig', [
           'garages'=>$garages,
           'materiels'=>$materiels
        ]);
    }


    #[Route('/addMateriel/{id}', name:'materiel_g')]
    public function goToMateriel($id , ManagerRegistry $mngr , Request $req ){

        $materiel = new Materiel();
        $garage = $mngr->getRepository(Garage::class)->find($id);

        $em=$mngr->getManager();

        $rep=$mngr->getRepository(Materiel::class);

        $materiels=$rep->getMaterielWithGarageId($id);

        $form=$this->createForm(MaterielType::class,$materiel);

        
        $form->handleRequest($req);



        if( $form->isSubmitted() && $form->isValid()){

            $materiel->setIdGarage($garage);
            $materiel->setDisponibilite(true);

            $em->persist($materiel);

            $em->flush();
            return  $this->redirectToRoute('materiel_g',['id' => $id]);
        
        }

        return $this->render('materiel/addMateriel.html.twig', [
         'form' => $form->createView(),
         'garage'=>$garage,
         'materiels'=>$materiels
        ]);

    }

    
    #[Route('/deleteMateriel/{id}', name:'app_deleteM')]
    public function deletMateriel($id , ManagerRegistry $doctrine)
    {

        $em=$doctrine->getManager();

        $materiel=$doctrine->getRepository(Materiel::class)->find($id);

        $em->remove($materiel);

        $em->flush();

        return  $this->redirectToRoute('app_materiel');

    }

    #[Route('/updateMateriel/{id}', name:'app_deleteM')]
    public function updateMateriel($id , ManagerRegistry $doctrine , Request $req)
    {

        $materiel=$doctrine->getRepository(Materiel::class)->find($id);

        $form=$this->createForm(UpdateMaterielType::class,$materiel);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_materiel');
        }

        return $this->render('materiel/updateMateriel.html.twig',[
            'form'=>$form->createView(),
            'm'=>$materiel
        ]);

    }


}
