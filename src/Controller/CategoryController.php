<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{

    #[Route('/article/{name}', name: 'article_search')]
    public function searchByCategory(PaginatorInterface $Paginator, Request $request, $name): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name'=>$name]);

        $articles = $Paginator->paginate(
            $category->getCategory()->getValues(),
            $request->query->getInt('page', 1),
            4
        );
        
        return $this->render('article/index.html.twig', [
            'articles' => $articles
           
        ]);

    }
}






// $cat->getCategory() devrait s'appeller getProducts() et renvoie une collection de persistance
// Doctrine possédent la méthode getValues() pour récupéré les élément de cette derniéres
