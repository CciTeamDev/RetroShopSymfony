<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService, PaginatorInterface $paginator, Request $request): Response
    {
        $CartArticles = $paginator->paginate(
            $cartService->getFullCart(),
            $request->query->getInt('page', 1),
            5
        );
        

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $CartArticles,
            'total' => $cartService->getTotal(),
            //'cart' => $CartArticles
        ]);
        // dd($cartService);
    }

    #[Route('/cart/add/{id}', name:"cart_add")]
    public function add($id,CartService $cartService){
        $cartService->add($id);
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name:"cart_remove")]
    public function remove($id, CartService $cartService){
        $cartService->remove($id);
        return $this->redirectToRoute("cart_index");
    }
}
