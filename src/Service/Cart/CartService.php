<?php

namespace App\Service\Cart;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\PurchaseHaveProduct as Cart;
use App\Entity\Purchase;

class CartService{

    protected $session;
    protected $articleRepository;
    private $entityManager;

    public function __construct(SessionInterface $session,ArticleRepository $articleRepository,$entityManager)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function add(int $id,int $qte,Purchase $purchase) { //ok

        $art = $this->entityManager->getRepository(Article::class)->findOneBy(['id'=>$id]);
        $cart = $this->entityManager->getRepository(Cart::class)->findBy(['purchase'=>$purchase,'article'=>$art]);
        
        if($cart === []){
            //dd('boop');
            $em = $this->entityManager;
            
            $cart = new Cart();
            $cart->setPurchase($purchase);
            $cart->setQuantity($qte);
            $cart->setArticle($art);

            $em->persist($cart); 
            $em->flush();
        } else {
            //dd('beep');
            $this->update($id,$qte,$purchase);
        }
        
    }

    public function update(int $id,int $qte,Purchase $purchase) { //ok
        
        $art = $this->entityManager->getRepository(Article::class)->findOneBy(['id'=>$id]);
        $cart = $this->entityManager->getRepository(Cart::class)->findBy(['purchase'=>$purchase,'article'=>$art]);
        //dd($art,$cart);
        $em = $this->entityManager;
        $cart = $em->getRepository(Cart::class)->findOneBy(['purchase'=>$purchase,'article'=>$art]);
        $qte = $cart->getQuantity() + $qte;
        $cart->setQuantity($qte);
        $em->flush();
    
    }

    public function remove(int $id,Purchase $purchase){ //ok
        $art = $this->entityManager->getRepository(Article::class)->findOneBy(['id'=>$id]);
        $panier = $this->entityManager->getRepository(Cart::class)->findOneBy(['purchase'=>$purchase,'article'=>$art]);
        $this->entityManager->remove($panier);
        $this->entityManager->flush();
    }

    public function getFullCart(Purchase $purchase){ //ok
        $panierWithData =[];
        $panier = $this->entityManager->getRepository(Cart::class)->findBy(['purchase'=>$purchase]);
        $art = $this->entityManager->getRepository(Article::class)->findAll();
        
        foreach($panier as $subPanier){
            $panierWithData[] = [
                'product' => $subPanier->getArticle(),
                'quantity'=> $subPanier->getQuantity()
            ];
        }
        return $panierWithData;
    }

   
    
    
    

    public function getTotal(Purchase $purchase):float{ //ok
        $total = 0;
        foreach($this->getFullCart($purchase) as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

}