<?php

namespace App\Service\Purchase;

use App\Entity\Article;
use App\Entity\Purchase;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Service\Cart\CartService;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PurchaseService{
    
    protected $session;
    protected $articleRepository;
    private $entityManager;

    public function __construct(SessionInterface $session,ArticleRepository $articleRepository,$entityManager)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function checkPurchase($purchase,$user,CartService $cartService){
        if($purchase === null) {
            $entityManager = $this->entityManager;

            $purchase = new Purchase();
            $purchase->setCreatedAt(new DateTimeImmutable());
            $purchase->setStatus('panier');
            $purchase->setTotal('0');
            $purchase->setIdStripe('bleh');
            $purchase->setUser($user);

            $entityManager->persist($purchase);
            $entityManager->flush(); 
    }}
}