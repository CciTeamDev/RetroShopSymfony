<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PurchaseHaveProduct;
use App\Entity\User;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService): Response //ok
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);
        //dd($cartService->getFullCart($purchase));
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $cartService->getFullCart($purchase),
            'total' => $cartService->getTotal($purchase)
        ]);
    }

    #[Route('/cart/add/{id}', name:"cart_add")]
    public function add($id,CartService $cartService,Request $request){ //ok

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);

        $cartService->add($id,$request->get('quantity'),$purchase);
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name:"cart_remove")]
    public function remove($id, CartService $cartService){ //ok

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);

        $cartService->remove($id,$purchase);
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
