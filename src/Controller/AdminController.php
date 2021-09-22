<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\PurchaseRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin',methods: ['GET'])]
    public function index(): Response
    { 
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/user', name: 'admin_user',methods: ['GET'])]
    public function showUser(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);

    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function deleteUser(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/', name: 'purchase_index', methods: ['GET'])]
    public function showPurchase(PurchaseRepository $purchaseRepository): Response
    {
        return $this->render('admin/purchase.html.twig', [
            'purchases' => $purchaseRepository->findAll(),
        ]);
    }

}
