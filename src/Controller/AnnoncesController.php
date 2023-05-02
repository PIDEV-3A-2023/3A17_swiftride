<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Annonces;
use App\Entity\Voiture;
use App\Entity\Utilisateur;
use App\Form\AnnonceType;
use App\Form\UpdateannonceType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'app_annonces')]
    public function createannonce(ManagerRegistry $doctrine , Request $req): Response
    {
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();
       

        $annonce=new Annonces();

        
        $voiture =$doctrine->getRepository(Voiture::class)->findAvailableVoituresQueryBuilder();
        $form = $this->createForm(AnnonceType::class, $annonce, ['myEntities' => $voiture]);
        
        $form->handleRequest($req);

        $em=$doctrine->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                $annonce->setImage($newFilename);
            }
            $em->persist($annonce);

            $em->flush();

            return $this->redirectToRoute('app_homeadmin');

        }

        return $this->render('annonces/index.html.twig', [
            'form'=>$form->createView(),
            'annonce'=>$annonce

            
        ]);
    }
#[Route('gestionannonce/update/{id}', name: 'gestionannonceupdate')]
public function update(Request $request, ManagerRegistry $doctrine, $id)
{
    $annonce = $doctrine->getRepository(Annonces::class)->find($id);
    $form = $this->createForm(UpdateannonceType::class, $annonce);
    $originalImage = $annonce->getImage();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // handle image file update
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // handle exception if something happens during file upload
            }

            $annonce->setImage($newFilename);
        } else {
            $annonce->setImage($originalImage);
        }

        $doctrine->getManager()->flush();
        $this->addFlash('success', 'Annonce updated successfully!');
        return $this->redirectToRoute('app_liste_annonces');
    }

    return $this->render('annonces/editannonce.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
