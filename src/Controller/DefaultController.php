<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class DefaultController extends AbstractController
{   
    #[Route('/', name: 'accueil_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {   
        return $this->render("default/index.html.twig", [
            'articles' => $articleRepository->showArticlesByDate(),
        ]);
    }

    // #[Route('/', name: 'accueil_index', methods: ['GET'])]
    // public function articleSuggestion(ArticleRepository $articleRepository,Request $request): Response
    // {

    //     $articles = $paginator->paginate(
    //         $articleRepository->findAll(),
    //         $request->query->getInt('page', 1),
    //         4
    //     );

    //     return $this->render('default/index.html.twig', [
    //         'articles' => $articles,
    //     ]);
    // }

    // public function categorie(): Response
    // {   
    //     return $this->render("categorie/index.html.twig", []);
    // }

}