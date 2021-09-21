<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Purchase;
use App\Form\UserType;
use App\Entity\PurchaseHaveProduct as Cart;
use App\Repository\UserRepository;
use App\Service\Cart\CartService;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/getter', name: 'user_getter')]
    public function userIdGetter(CartService $cartService){
        $panier = $cartService->getFullCart();
        dd($panier);
        $boo = $this->getUser();
        if($boo) {
            $boot = $boo->getId();
            
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$boot]);
            $purchase = $this->getDoctrine()->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);

            //dd($purchase);
            if($purchase !== null) {
                
                $art = $this->getDoctrine()->getRepository(Article::class)->findAll();

                $cart = $this->getDoctrine()->getRepository(Cart::class)->findBy(['purchase'=>$purchase]);
                
                dd($cart,$purchase,'bleep');


            } else {

                $entityManager = $this->getDoctrine()->getManager();

                $purchase = new Purchase();
                $date = new DateTimeImmutable();
                $purchase->setCreatedAt($date);
 
                $purchase->setStatus('panier');
                $purchase->setTotal('0');
                $purchase->setIdStripe('bleh');
                $purchase->setUser($user);

                $entityManager->persist($purchase);
                $entityManager->flush();
            }
            
            dd($purchase,$boot);
        } else {
            $boo = 'vide';
        }
        dd($boo);
    }

    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
