<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\User;
use App\Form\PurchaseType;
use App\Repository\PurchaseRepository;
use App\Service\Cart\CartService;
use App\Service\Purchase\ChartPurchaseService;
use App\Service\Purchase\PurchaseService;
use App\Service\StripeService;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'purchase')]
    public function index(PurchaseService $purchaseService): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user' => $user, 'status' => 'panier']);
        $purchaseService->checkPurchase($purchase, $user);
        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }



    #[Route('/purchase/history/year', name: 'purchase_historyYear')]
    public function purchaseHistoryYear(ChartBuilderInterface $chartBuilder,PurchaseService $purchaseService, ChartPurchaseService $chartPurchaseService): Response
    {

        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findBy(['status' => 'complete']);
        $yearChart = $chartPurchaseService->barChartPastYear($chartBuilder, $purchase);
        $superTotal = $purchaseService->totalPurchaseYear($purchase);

        return $this->render('purchase/showYear.html.twig', [
            'controller_name' => 'PurchaseController',
            'chart' => $yearChart,
            'superTotal'=>$superTotal
        ]);
    }

    #[Route('/purchase/history/month', name: 'purchase_historyMonth')]
    public function purchaseHistoryMonth(ChartBuilderInterface $chartBuilder, PurchaseService $purchaseService, ChartPurchaseService $chartPurchaseService): Response
    {

        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findBy(['status' => 'complete']);
        $monthChart = $chartPurchaseService->barChartPastMonth($chartBuilder, $purchase);
        $superTotal = $purchaseService->totalPurchaseMonth($purchase);

        return $this->render('purchase/showMonth.html.twig', [
            'controller_name' => 'PurchaseController',
            'chart' => $monthChart,
            'superTotal'=>$superTotal
        ]);
    }
    #[Route('/purchase/history/{id}', name: 'purchase_history')]
    public function purchaseHistory($id, ChartBuilderInterface $chartBuilder, PurchaseService $purchaseService, CartService $cartService, ChartPurchaseService $chartPurchaseService): Response
    {

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findBy(['user' => $user, 'status' => 'complete']);
        $callOnService = $purchaseService->purchaseHistory($purchase, $cartService);

        $mixedChartOnUser = $chartPurchaseService->mixedChartOneUser($chartBuilder, $purchase);

        return $this->render('purchase/show.html.twig', [
            'controller_name' => 'PurchaseController',
            'callOnService' => $callOnService,
            'chartMixed' => $mixedChartOnUser
        ]);
    }

    #[Route('/purchase/validate/{id}', name: 'purchase_validator')]
    public function purchaseValidator(

        CartService $cartService,Purchase $purchase, StripeService $stripeService,
        Request $request, UrlGeneratorInterface $generator): Response
    {
        $cart = $cartService->getFullCart($purchase);

        $total = $cartService->getTotal($purchase);


        $form = $this->createForm(PurchaseType::class,null,[
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form->getData()['adresse'] === null){
                $this->addFlash('notice', 'Veuillez rentrer une adresse de livraison');
            } else {
                return $this->redirect($stripeService->getArrayResponse($cart, $form, $purchase,$generator, $this->getParameter('secretStripe')));
            }
        }

        return $this->render('purchase/index.html.twig',
            [
                'cart' => $cart,
                'form' => $form->createView(),
                'total' => $total
            ]);


    }

    #[Route('/purchase/success/merci/{id}', name: 'order_success')]
    public function paymentSuccess(Request $request, Purchase $purchase, StripeService $stripeService)
    {
        if($stripeService->checkSuccess($purchase, $this->getParameter('secretStripe')))
        {
           return $this->render('order/success.html.twig',[
               'purchase' => $purchase
           ]);
        }
    }

    #[Route('/purchase/failed/desole/{id}', name: 'order_failed')]
    public function paymentFailed(Purchase $purchase)
    {
        return $this->render('order/failed.html.twig',[
            'purchase' => $purchase
        ]);
    }
}
