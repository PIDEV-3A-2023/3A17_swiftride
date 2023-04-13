<?php

namespace App\Controller;

use App\Form\MoyenTransportType;
use App\Entity\MoyenTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MoyenTransportRepository;
//use Doctrine\Persistence\ObjectManager;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Faker\Factory;

/*class MoyenTransportController extends AbstractController 
{
    public function __construct(
        private MoyenTransportRepository $moyentransportRepository
    ) { 
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $moyentransports= [];
        for($i = 0; $i < 10; $i++){
            $moyentransport = new MoyenTransport();
            $moyentransport->setName($faker->words(1,true) . ' ' . $i)
                           ->setDescription(
                            mt_rand(0, 1) === 1 ? $faker->realText(254) : null
                           );

            $manager->persist($moyentransport);
            $moyentransports[] = $moyentransport;
        }

        $stations = $this->StationRepository->findAll();

        foreach ($stations as $station) {
            $station->addMoyenTransport(
                $moyentransports[mt_rand(0, count($moyentransports) - 1)]
            );
            
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [StationController::class];
    }
}*/

class MoyenTransportController extends AbstractController 
{

    #[Route('/moyentransport', name: 'app_moyentransport')]
    public function index(): Response
    {
        $MoyenTransport = $this->getDoctrine()->getManager()->getRepository(MoyenTransport::class)->findAll();
        $form = $this->createForm(MoyenTransportType::class);
        return $this->render('moyen_transport/index.html.twig', [
            't'=>$MoyenTransport

        ]);
       
    }
   
    /**
     * @Route("/addmoyentransport", name="addMoyenTransport")
     */

    public function addMoyenTransport(Request $request): Response
    {
        $MoyenTransport = new MoyenTransport();
        $form = $this->createForm(MoyenTransportType::class, $MoyenTransport);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($MoyenTransport);//Add
            $em->flush();

            return $this->redirectToRoute('app_moyentransport');
        }
        return $this->render('moyen_transport/createMoyenTransport.html.twig',['f'=>$form->createView()]);



    }

    #[Route('/removeMoyenTransport/{id}', name: 'supmoyentransport')]
    public function suppressionMoyenTransport(MoyenTransport $MoyenTransport): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($MoyenTransport);
        $em->flush();
        
        
        //return$this->redirectToRoute('supmoyentransport');
        return $this->redirectToRoute('app_moyentransport', ['id' => $MoyenTransport->getId()]);


    }


    #[Route('/modifmoyentransport/{id}', name: 'modifMoyenTransport')]
     public function modifMoyenTransport(Request $request,$id): Response
     {
         $MoyenTransport = $this->getDoctrine()->getManager()->getRepository(MoyenTransport::class)->find($id);
         $form = $this->createForm(MoyenTransportType::class, $MoyenTransport);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->flush();
 
             return $this->redirectToRoute('app_moyentransport');
         }
         return $this->render('moyen_transport/updateMoyenTransport.html.twig',['f'=>$form->createView()]);
 
     }

    }