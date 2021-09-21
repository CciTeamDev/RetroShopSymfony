<?php

namespace App\Controller;

use App\Entity\PurchaseHaveProduct;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    #[Route('/cart/add/{id}', name:"cart_add")]
    public function add($id,CartService $cartService,Request $request){
        $cartService->add($id,$request->get('quantity'));
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name:"cart_remove")]
    public function remove($id, CartService $cartService){
        $cartService->remove($id);
        return $this->redirectToRoute("cart_index");
    }

    //#[Route('/cart/update/{id}', name:"cart_update")]
    //public function update($id, CartService $cartService){
    //    $cartUpdate = $cartService->update($id);
    //    if($cartUpdate === false) {
    //        return $this->redirectToRoute("article_index");
    //    }
    //    return $this->redirectToRoute("cart_index");
    //}
}
