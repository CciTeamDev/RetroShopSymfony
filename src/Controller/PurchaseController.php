<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\User;
use App\Form\PurchaseType;
use App\Service\Cart\CartService;
use App\Service\Purchase\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'purchase')]
    public function index(PurchaseService $purchaseService): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);
        $purchaseService->checkPurchase($purchase,$user);
        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }

    #[Route('/purchase/history/{id}', name: 'purchase_history')]
    public function purchaseHistory($id,PurchaseService $purchaseService,CartService $cartService): Response
    {   
        
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$id]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findBy(['user'=>$user,'status'=>'complete']);
        $bleep = $purchaseService->purchaseHistory($purchase,$cartService);
    
        return $this->render('purchase/show.html.twig', [
            'controller_name' => 'PurchaseController',
            'bleep'=>$bleep,
        ]);
    }

    #[Route('/purchase/validate/{id}', name: 'purchase_validator')]
    public function purchaseValidator(CartService $cartService,Purchase $purchase): Response
    {
        
        $form = $this->createForm(PurchaseType::class,null,[
            'user' => $this->getUser()
        ]);

        return $this->render('purchase/index.html.twig',
            ['cart' => $cartService->getFullCart($purchase),
                'form' => $form->createView()
            ]);
    }
}
