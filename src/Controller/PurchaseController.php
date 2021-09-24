<?php

namespace App\Controller;

use App\Service\Purchase\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'purchase')]
    public function index(): Response
    {
        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }

    #[Route('/purchase/history', name: 'purchase')]
    public function purchaseHistory(PurchaseService $purchaseService): Response
    {   
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'complete']);
        $purchaseService->purchaseHistory($purchase);
        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }
}
