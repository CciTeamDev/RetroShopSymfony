<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Ratings;
use App\Entity\User;
use App\Repository\RatingsRepository;
use App\Service\Ratings\RatingsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ratings')]
class RatingsController extends AbstractController
{
    #[Route('/', name: 'index_ratings')]
    public function index(): Response
    {
        return $this->render('ratings/index.html.twig', [
            'controller_name' => 'RatingsController',
        ]);
    }

    #[Route('/add/{id}', name: 'ratings_add')]
    public function addRatings($id, Request $request, RatingsService $ratingsService)
     {  
        //user
        // permet d'ajouter une note et un commentaire a un article
        // envoie en vérification au près de l'admin
        // dd($this->getUser()->getId());
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=> $this->getUser()->getId()]);
        $note = $request->get('note');
        $comment = $request->get('comment');
        $ratingsService->add($id, $user, $note, $comment);
      
        return $this->redirectToRoute('article_index');
    }
    
    public function showunModeratedRatings()
    { //admin
        // appel a un service et retrouve tous les commentaires qui n'ont pas été modéré
        // bouton validé ou rejeté
    }

    public function validateRatings()
    { //admin
        // valide le ratings de l'user
    }

    public function rejectRatings()
    {//admin
        // rejete le ratings de l'user
    }
    
    public function showAllRatings()
    { //admin
        // renvoi tous les ratings pour un article
        // bouton delete
        // bouton remise en modération
    }

    #[Route('/show/{id}', name: 'ratings_show')]
    public function showRatings($id, RatingsService $ratingsService)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['id'=> $id]);
        // dd($article);
        $boo = $ratingsService->show($article);

        //page user
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'ratings' => $boo
        ]);

    }
    

    public function updateRatings()
    {//user
        // modifier commentaire coté user
    }

    #[Route('/{id}/delete', name: 'ratings_delete', methods: ['POST'])]
    public function removeRatings(Request $request, Ratings $ratings): Response
    {   
        //user
        // supprime le ratigns
        if ($this->isCsrfTokenValid('delete'.$ratings->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ratings);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }
}
