<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PurchaseHaveProduct;
use App\Entity\User;
use App\Service\Cart\CartService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService, PaginatorInterface $paginator, Request $request): Response //ok
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);
        $CartArticles = $paginator->paginate(
            $cartService->getFullCart($purchase),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $CartArticles,
            'total' => $cartService->getTotal($purchase),
            'purchase' => $purchase
        ]);
        
    }

    #[Route('/cart/add/{id}', name:"cart_add")]
    public function add($id,CartService $cartService,Request $request){ //ok

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);

        if($request->get('quantity') === null) {
            $patch = 1;
        } else {
            $patch = $request->get('quantity');
        }
        
        $cartService->add($id,$patch,$purchase);
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name:"cart_remove")]
    public function remove($id, CartService $cartService){ //ok

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);

        $cartService->remove($id,$purchase);
        return $this->redirectToRoute("cart_index");
    }
}