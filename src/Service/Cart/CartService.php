<?php

namespace App\Service\Cart;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{

    protected $session;
    protected $articleRepository;

    public function __construct(SessionInterface $session,ArticleRepository $articleRepository)
    {
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function add(int $id,int $qte) {

        $panier = $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier = $this->update($id,$qte);
        } else {
            $panier[$id] = $qte;
        }
        $this->session->set('panier',$panier);
    }

    public function update(int $id,int $qte) {
    
        $panier = $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]+=$qte;
        } else {
            $error_message = false;
            return $error_message;
        }
        return $panier;
    }

    public function remove(int $id){
        $panier = $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier [$id]);
        }

        $this->session->set('panier',$panier);

    }

    public function getFullCart():array{
        $panier = $this->session->get('panier',[]);
        $panierWithData = [];
        
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'product' => $this->articleRepository->find($id),
                'quantity'=>$quantity
            ];
        }
        return $panierWithData;
    }

    public function getTotal():float{
        $total = 0;
        

        foreach($this->getFullCart() as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}