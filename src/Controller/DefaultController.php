<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accueil')]
class DefaultController extends AbstractController
{   
    #[Route('/', name: 'accueil_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {   
        return $this->render("default/index.html.twig", [
        'users' => $userRepository->findAll()
        ]);
    }

    

    // public function categorie(): Response
    // {   
    //     return $this->render("categorie/index.html.twig", []);
    // }

}