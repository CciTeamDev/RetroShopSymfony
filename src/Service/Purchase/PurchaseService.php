<?php

namespace App\Service\Purchase;

use App\Entity\Article;
use App\Entity\Purchase;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Service\Cart\CartService;
use DateInterval;
use DateTime;
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

    public function checkPurchase($purchase,$user){
        if($purchase === null) {
            $entityManager = $this->entityManager;

            $purchase = new Purchase();
            $purchase->setCreatedAt(new DateTimeImmutable());
            $purchase->setStatus('panier');
            $purchase->setTotal('0');
            $purchase->setUser($user);

            $entityManager->persist($purchase);
            $entityManager->flush();
    }}

    public function validatePurchase($purchase,CartService $cartService){
        if($purchase) {
            $entityManager = $this->entityManager;
            $date = new DateTime();
            $reference = $date->format("dmY")."-".uniqid();
            $purchase->setTotal($cartService->getTotal($purchase));
            $purchase->setCreatedAt(new DateTimeImmutable());
            $purchase->setStatus('complete');
            $purchase->setReference($reference);

            $entityManager->persist($purchase);
            $entityManager->flush(); 
    }}

    public function purchaseHistory($purchase,CartService $cartService){
        $subpurchase =[];
        
        foreach($purchase as $hpurchase){
            $fcart = ['purchase'=> $hpurchase, 'cart'=>$cartService->getFullCart($hpurchase)];
            $subpurchase[] = $fcart;
        }
        return $subpurchase;
    }

    public function totalPurchaseMonth($purchase){
        
        
        $interval = new DateInterval('P1D');
        $target = new DateTime();
        $clonedA = clone $target;
        $clonedA->modify('-1 month');
        $clonedB = clone $target;
        $clonedB->modify('-1 month');

        $monthLabel= [];
        $dailyTotal=[];
        $total =0;

        $dayInMonth=[
            'Jan'=>31,
            'Feb'=>28,
            'Mar'=>31,
            'Apr'=>30,
            'May'=>31,
            'Jun'=>30,
            'Jul'=>31,
            'Aug'=>31,
            'Sep'=>30,
            'Oct'=>31,
            'Nov'=>30,
            'Dec'=>31
        ];
        $formatDate = 'd,M';
        $superTotal = 0;

        foreach($dayInMonth as $key => $nbDays){
            
            if($clonedB->format('M') === $key){
                
                for($i=0;$i<=$nbDays;$i++){
                    
                    if($i===0){
        
                        
                        $this->boucleChart($clonedA,$purchase,$total,$formatDate);
                        $superTotal += $this->boucleChart($clonedA,$purchase,$total,$formatDate);
                        $total = 0;
                        
                        
                    } else {
                        
                        $clonedA->add($interval);
                        $superTotal += $this->boucleChart($clonedA,$purchase,$total,$formatDate);
                        $total = 0;
                        
                    }
                }
                
            } else {
                continue;
            }
        }
        
        return $superTotal;
    }

    public function totalPurchaseYear($purchase){
        $interval = new DateInterval('P1M');
        $target = new DateTime();
        $cloned = clone $target;
        $cloned->modify('-1 year');
        
        $monthArrayLabel= [];
        $monthlyTotal=[];
        $total =0;
        $superTotal = 0;

        $formatDate='m,Y';

        for($i=0;$i<=11;$i++){

            if($i===0){
                
                
                $this->boucleChart($cloned,$purchase,$total,$formatDate);
                $superTotal += $this->boucleChart($cloned,$purchase,$total,$formatDate);
                $total = 0;
                
            } else {
                
                $cloned->add($interval);
                $superTotal += $this->boucleChart($cloned,$purchase,$total,$formatDate);
                $total = 0;

            }
        }
        return $superTotal;

    }

    public function boucleChart($cloned,$purchase,$total,$formatDate){
        
        foreach($purchase as $purchy){
            if($purchy->getCreatedAt()->format($formatDate)==$cloned->format($formatDate)){
                $total += $purchy->getTotal();
            } else {
                continue;
            }
            
        }
        return $total;
}
    
}