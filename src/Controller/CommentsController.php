<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Form\ValidateType;
use App\Repository\ArticleRepository;
use App\Repository\CommentsRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comments')]
class CommentsController extends AbstractController
{
    #[Route('/{id}', defaults:['id' => 0], name: 'comments_index', methods: ['GET'])]
    public function index(CommentsRepository $commentsRepository,?Comments $comment, Request $request): Response
    {   
        if(is_string($request->query->get('moderate')) && $comment instanceof Comments){
            $em = $this->getDoctrine()->getManager();
                
                if($request->query->get('moderate') == 1){
                    $comment->setModerate(1);

                    $em->persist($comment);
                    $em->flush();
                    
                    return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
                }

                if($request->query->get('moderate') == 0){
                    $comment->setModerate(0);

                    $em->remove($comment);
                    $em->flush();
    
                    return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
                }
    
        }
        
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll()
        ]);
    }

     #[Route('/new', name: 'comments_new', methods: ['GET', 'POST'])]
    // public function new(Request $request): Response
    // {
    //     $comment = new Comments();
    //     $form = $this->createForm(Comments1Type::class, $comment);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($comment);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('comments/new.html.twig', [
    //         'comment' => $comment,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'comments_show', methods: ['GET'])]
    public function show(Comments $comment): Response
    {
        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'comments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'comments_delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
