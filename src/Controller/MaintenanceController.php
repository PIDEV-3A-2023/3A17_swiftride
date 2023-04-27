<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Maintenance;
use App\Entity\Voiture;
use App\EventSubscriber\PdfService;
use App\Form\MaintenanceType;
use App\Form\RendezVousType;
use App\Form\SuiteRendezVousType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(ManagerRegistry $doctrine ): Response
    {
        $maintenances = $doctrine->getRepository(Maintenance::class)->findAll();

        return $this->render('maintenance/index.html.twig', [
            'maintenances'=>$maintenances
        ]);
    }


    #[Route('/deleteMaintenence/{id}', name: 'delete_maintenance')]
    public function deleteMaintenance($id,ManagerRegistry $doctrine)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        return $this->redirectToRoute('app_maintenance');
    }

    #[Route('/SupprimerMaintenace/{id}', name: 'supp_maint')]
    public function deleteMaintenanceClient($id,ManagerRegistry $doctrine)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        return $this->redirectToRoute('histo_client');
    }

    #[Route('/updateMaintenance/{id}', name: 'update_maintenance')]
    public function updateMaintenance($id , ManagerRegistry $doctrine , Request $req)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        
        $garages=$doctrine->getRepository(Garage::class)->findAll();

        $form=$this->createForm(MaintenanceType::class,$maintenance, [
            'myEntities' => $garages,
        ]);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $datesrc= $form->get('dateMaintenance')->getData();
            $date = new \DateTime($datesrc->format('Y-m-d H:i:s'));

            $maintenance->setFinMaintenance($date->modify('+2 hours'));

            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('app_maintenance');

        }

        return $this->render('maintenance/updateMaintenance.html.twig', [
            'form'=>$form->createView(),
            'm'=>$maintenance
        ]);

    }

    #[Route('/partenairecars/{id}', name: 'cars_maintenance')]
    public function dataTable(ManagerRegistry $doctrine , $id){

        $partenaire = $doctrine->getRepository(Voiture::class)->find($id);

        $cars= $doctrine->getRepository(Voiture::class)->getCarsWithPartnerId($id);

        return $this->render('maintenance/voiturePourLesmaintenace.html.twig', [
            'voitures'=>$cars,
            'partenaire'=>$partenaire
        ]);

    }

    #[Route('/rendez-vous/{id}', name: 'rendez_vous')]
    public function passerRendezVous(Request $req , ManagerRegistry $doctrine , $id){

        $voiture=$doctrine->getRepository(Voiture::class)->find($id);

        $garages=$doctrine->getRepository(Garage::class)->findAll();

       // $maintenance = new Maintenance();

        $form= $this->createForm(RendezVousType::class,null,[
            'myEntities' => $garages,
        ]);

        $form->handleRequest($req);


       
        if($form->isSubmitted() && $form->isValid())
        {


            $datesrc= $form->get('dateMaintenance')->getData();
            $date = new \DateTime($datesrc->format('Y/m/d'));

            $garage=$form->get('idGarage')->getData();

            $idg=$garage->getId();
            $idv =$voiture->getId();

            $datev=$date->format('Y-m-d');
            
          

            return $this->redirectToRoute('finale_etape',['id'=>$idv,'d'=>$datev , 'idg'=>$idg]);
        }

        return $this->render('maintenance/rendez-vousMaintenance.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture
        ]);

    }

    #[Route('/rendez-vous1/{id}/{d}/{idg}', name: 'finale_etape')]
    public function rendezVous(ManagerRegistry $doctrine , Request $req  , $id , $idg , $d){

        $voiture=$doctrine->getRepository(Voiture::class)->find($id);

        $garage=$doctrine->getRepository(Garage::class)->find($idg);

        $time=[];

        $maintenances=$doctrine->getRepository(Maintenance::class)->getMaitenanceWithGarageAndDate($idg,$d);

        $length = count($maintenances);
        if($length==0){
            array_push($time,"08:00:00","10:30:00","13:00:00","15:30:00");
        }
        else{

            $tabTimes=["08:00:00","10:30:00","13:00:00","15:30:00"];
            
             
           
        foreach ( $maintenances as $m){
            $time1=$m->getDateMaintenance()->format('H:i:s');
            $found=false;
             
            foreach($tabTimes as $s){

                $time2=DateTime::createFromFormat('H:i:s' , $s);

                if($time1==$time2){
                    $found=true;
                    break;

                }
            }

            
            if(!$found && isset($time2)){
                $time[]=$time2->format('H:i:s');
            }

            /*$val1=strcmp($m->getDateMaintenance()->format('H:i:s') , '08:00:00');
            if($val1!=0){

                array_push($time,"8:00:00");
        }
        $val2=strcmp($m->getDateMaintenance()->format('H:i:s') , '10:30:00');
         if($val2!=0)
        {
            array_push($time,"10:30:00");
        }
        $val3=strcmp($m->getDateMaintenance()->format('H:i:s') , '13:00:00');
         if($val3!=0){
            array_push($time,"13:00:00");
        }
        $val4=strcmp($m->getDateMaintenance()->format('H:i:s') , '15:30:00');
         if($val4!=0 ){
            array_push($time,"15:30:00");
        }
*/
        }
    }

        $form=$this->createForm(SuiteRendezVousType::class ,null,[
            'myEntities' => $time,
        ]);

        $form->handleRequest($req);


        $maintenance = new Maintenance();
        
         $em=$doctrine->getManager();

        if($form->isSubmitted() && $form->isValid()){

            //concatiner date + heur 
            $t=$form->get('temps')->getData();

            $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $d . ' ' . $t);


            $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

            $maintenance->setDateMaintenance($dateHeure);
            $maintenance->setIdGarage($garage);
            $maintenance->setIdVoiture($voiture);
            $maintenance->setType($form->get('type')->getData());
            $maintenance->setFinMaintenance($date->modify('+2 hours'));

            $em->persist($maintenance); 

            $em->flush(); 

            return $this->redirectToRoute('app_maintenance');

        }

        return $this->render('maintenance/suiteRende-vous.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture
        ]);

    }

    #[Route('/passerRendez-vous/{id}', name: 'client_rv')]
    public function passerRendezVousClient( ManagerRegistry $doctrine , Request $req , $id){


        $voiture=$doctrine->getRepository(Voiture::class)->find($id);
        $garages=$doctrine->getRepository(Garage::class)->findAll();

        $form = $this->createForm(RendezVousType::class , null , ['myEntities' => $garages,]);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid() )
        {


            $datesrc= $form->get('dateMaintenance')->getData();
            $date = new \DateTime($datesrc->format('Y/m/d'));

            $garage=$form->get('idGarage')->getData();

            $idg=$garage->getId();
            $idv =$voiture->getId();

            $datev=$date->format('Y-m-d');
            
          

            return $this->redirectToRoute('final_client',['idv'=>$idv,'da'=>$datev , 'idgr'=>$idg]);
        }

        return $this->render('maintenance/rendez-vouMaintClient.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture
        ]);
    }


    
    #[Route('/rendez-vous-client/{idv}/{da}/{idgr}', name: 'final_client')]
    public function rendezVousClient(ManagerRegistry $doctrine , Request $req  , $idv , $idgr , $da){

        $voiture=$doctrine->getRepository(Voiture::class)->find($idv);

        $garage=$doctrine->getRepository(Garage::class)->find($idgr);

        $time=[];

        $maintenances=$doctrine->getRepository(Maintenance::class)->getMaitenanceWithGarageAndDate($idgr,$da);

        $length = count($maintenances);
        if($length==0){
            array_push($time,"8:00:00","10:30","13:00","15:30");
        }
        else{
            $tabTimes=["08:00:00","10:30:00","13:00:00","15:30:00"];
           
        foreach ( $maintenances as $m){

            $time1=$m->getDateMaintenance()->format('H:i:s');
            $found=false;
             
            foreach($tabTimes as $s){

                $time2=DateTime::createFromFormat('H:i:s' , $s);

                if($time1==$time2){
                    $found=true;
                    break;

                }
            }

            
            if(!$found && isset($time2)){
                $time[]=$time2->format('H:i:s');
            }


       /*     $val1=strcmp($m->getDateMaintenance()->format('H:i:s') , '08:00:00');
            if($val1!=0){

                array_push($time,"8:00:00");
        }
        $val2=strcmp($m->getDateMaintenance()->format('H:i:s') , '10:30:00');
         if($val2!=0)
        {
            array_push($time,"10:30:00");
        }
        $val3=strcmp($m->getDateMaintenance()->format('H:i:s') , '13:00:00');
         if($val3!=0){
            array_push($time,"13:00:00");
        }
        $val4=strcmp($m->getDateMaintenance()->format('H:i:s') , '15:30:00');
         if($val4!=0 ){
            array_push($time,"15:30:00");
        }
*/
        }
    }

        $form=$this->createForm(SuiteRendezVousType::class ,null,[
            'myEntities' => $time,
        ]);

        $form->handleRequest($req);


        $maintenance = new Maintenance();
        
         $em=$doctrine->getManager();

        if($form->isSubmitted() && $form->isValid()){

            //concatiner date + heur 
            $t=$form->get('temps')->getData();

            $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $da . ' ' . $t);


            $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

            $maintenance->setDateMaintenance($dateHeure);
            $maintenance->setIdGarage($garage);
            $maintenance->setIdVoiture($voiture);
            $maintenance->setType($form->get('type')->getData());
            $maintenance->setFinMaintenance($date->modify('+2 hours'));

            $em->persist($maintenance); 

            $em->flush(); 

            return $this->redirectToRoute('histo_client');

        }

        return $this->render('maintenance/suiteRendez-vousClient.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture
        ]);

    }


    #[Route('/calendrier', name: 'app_calender')]
    public function calendrierDesMaintenance(){
        return $this->render('maintenance/calendrierDesMaintenances.html.twig');

    }

    #[Route('/detailMaintenance/{id}', name: 'app_detail_maint')]
    public function detailMaintenance(ManagerRegistry $doctrine , $id){

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);



        return $this->render('maintenance/detailMaintenance.html.twig',[
            "maintenance"=>$maintenance,
        ]);
    }

    #[Route('/detailMaintenanceClient/{id}', name: 'app_detail_maint_client')]
    public function detailMaintenanceClient(ManagerRegistry $doctrine , $id){

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);



        return $this->render('maintenance/detailMaintenanceClient.html.twig',[
            "maintenance"=>$maintenance,
        ]);
    }

    #[Route('/pdf/{id}', name: 'app_pdf')]
    public function pdfFile( $id , ManagerRegistry $doctrine , PdfService $pdf){

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);

        $html= $this->renderView('maintenance/pdfDetail.html.twig',[
            "maintenance"=>$maintenance,
        ]);

        $pdf->showPdfFile($html);
        
        return new Response('',200);
    }

    #[Route('/clientMaintHisto', name: 'histo_client')]
    public function historiqueMaintenanceClient(ManagerRegistry $doctrine){

        $id = 4;

        //if($this->getUser()->getRole()->getId()==2 );
        $maint=$doctrine->getRepository(Maintenance::class)->getHistoMaintForClient($id);

        return $this->render('maintenance/histroqueMaintenanceClinet.html.twig',[
            "maintenances"=>$maint
        ]);

    }
    

    #[Route('/historiqueMaintenance', name: 'histo_Entre')]
    public function historiqueMaintenance(ManagerRegistry $doctrine){

        $id = 4; //$this->getUser()->getId();

        //if($this->getUser()->getRole()->getId()!=1 && $this->getUser()->getRole()->getId()!=2 );
        $maint=$doctrine->getRepository(Maintenance::class)->getHistoMaintForClient($id);

        return $this->render('maintenance/histoMaintenance.html.twig',[
            "maintenances"=>$maint
        ]);

    }

}
