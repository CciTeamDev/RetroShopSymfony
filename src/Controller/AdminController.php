<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\PurchaseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


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

    #[Route('/purchase', name: 'admin_purchase', methods: ['GET'])]
    public function showPurchase(PurchaseRepository $purchaseRepository): Response
    {
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchaseRepository->findAll(),
        ]);
    }

    #[Route('/{id}/admin', name: 'user_delete_admin', methods: ['POST']),]
    public function delete(Request $request, User $user): Response
    {
        if($this->isGranted('ROLE_ADMIN')){
            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
        } else {
            throw new AuthenticationException();
        }
        return $this->redirectToRoute('admin_user', [], Response::HTTP_SEE_OTHER);
    }
}
