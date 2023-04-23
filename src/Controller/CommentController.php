<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\EntreprisePartenaire;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/entreprise-partenaire/{id}/add-commentaire", name="addcommentaire")
     */
    public function addCommentaire(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $entreprisePartenaire = $entityManager->getRepository(EntreprisePartenaire::class)->find($id);

        $commentaire = new Comment();
        $commentaire->setEntreprisePartenaire($entreprisePartenaire);

        $form = $this->createForm(CommentType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_entreprisepartenaire', ['id' => $entreprisePartenaire->getId()]);
        }

        return $this->render('comment/CreateComment.html.twig', [
            'form' => $form->createView(),
            'entreprisePartenaire' => $entreprisePartenaire
        ]);
    }
}
