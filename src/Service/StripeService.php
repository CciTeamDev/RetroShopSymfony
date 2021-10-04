<?php

namespace App\Service;

use Stripe\Stripe;
use App\Entity\Purchase;
use Stripe\Checkout\Session;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeService
{

    public function __construct(private $em) {

    }


    public function getArrayResponse(
        array $cart, Form $form,
        Purchase $purchase, UrlGeneratorInterface $generator, string $key): string
    {
        $session = $this->getSession($cart, $form, $purchase, $generator, $key);
        $purchase->setIdStripe($session->id);
        $this->em->persist($purchase);
        $this->em->flush();
        return $session->url;
    }

    public function checkSuccess(Purchase $purchase,string $key)
    {
        Stripe::setApiKey($key);
        $retrievedCheckout = Session::Retrieve($purchase->getIdStripe());
        if($retrievedCheckout->payment_status === 'paid')
        {
            $purchase->setStatus("complete");
            $this->em->persist($purchase);
            $this->em->flush();
            return true;
        }
        return false;
    }


    private function getSession(array $cart, Form $form, Purchase $purchase, UrlGeneratorInterface $generator, string $key): Session
    {

        Stripe::setApiKey($key);
        return Session::create([
            'customer_email' => $purchase->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [$this->getProductForStripe($cart, $form)],
            'mode' => 'payment',
            'success_url' =>$generator->generate('order_success',['id' => $purchase->getId()],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $generator->generate('order_failed',['id' => $purchase->getId()],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);


        
    }

    private function getProductForStripe(array $cart, Form $form): array
    {
        $products_for_stripe = [];
        foreach ($cart as $product) {

            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice()*100,
                    'product_data' => [
                        'name' => $product['product']->getName()
                    ],
                ],
                'quantity' => $product['quantity']
            ];
            
        }
        $products_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $form['carrier']->getData()->getPrice()*100,
                'product_data' => [
                    'name' => $form['carrier']->getData()->getName()
                ],
            ],
            'quantity' => 1
        ];

        return $products_for_stripe;
    }

}
