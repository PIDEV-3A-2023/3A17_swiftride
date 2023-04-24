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
 * @Route("/addcommentaire/{id}", name="addcommentaire")
 */
public function addCommentaire(Request $request, EntreprisePartenaire $entreprisePartenaire)
{
    $comment = new Comment();
    $comment->setEntreprisePartenaire($entreprisePartenaire);

    $form = $this->createForm(CommentType::class, $comment);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Comment added successfully.');

        return $this->redirectToRoute('list');
    }

    return $this->render('comment/CreateComment.html.twig', [
        'form' => $form->createView(),
        'entreprisePartenaire' => $entreprisePartenaire,
    ]);
}

/**
 * @Route("/commentaire/supprimer/{id}", name="supprimer_commentaire")
 */
public function supprimerCommentaire(Request $request, Comment $commentaire): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($commentaire);
    $entityManager->flush();
    $this->addFlash('success', 'Commentaire supprimé avec succès.');

    return $this->redirectToRoute('list');
}

}