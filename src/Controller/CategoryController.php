<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{

    #[Route('/article/{name}', name: 'article_search')]
    public function searchByCategory(CategoryRepository $categoryRepository,ArticleRepository $articleRepository, Request $request, $name): Response
    {

        
        $cat = $categoryRepository->findOneBy([
            'name' => $name
        ]);

        // $cat->getCategory() devrait s'appeller getProducts() et renvoie une collection de persistance
        // Doctrine possédent la méthode getValues() pour récupéré les élément de cette derniéres

        return $this->render('article/index.html.twig', [
            'articles' => $cat->getCategory()->getValues()
           
        ]);

    }
}
