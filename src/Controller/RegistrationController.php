<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\Cart\CartService;
use App\Service\Purchase\PurchaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends AbstractController
{

    private array $service = [];

    public function __construct(UrlGeneratorInterface $urlGenerator,EntityManagerInterface $em,CartService $cartService,PurchaseService $purchaseService)
    {
        $this->urlGenerator = $urlGenerator;
        $this->service['Cart']=$cartService;
        $this->service['Purchase']=$purchaseService;
        $this->em = $em;
    }


    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();

            $token = new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                'main',
                $user->getRoles()
            );

            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            $this->leTest($this->service['Purchase'],$token->getUser());
            // do anything else you need here, like send an email
            return $this->redirectToRoute('article_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    protected function leTest(PurchaseService $purchaseService,$user){

        if($user) {
            $user = $this->em->getRepository(User::class)->findOneBy(['id'=>$user->getId()]);
            $purchase = $this->em->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);
            $purchaseService->checkPurchase($purchase,$user);
        }
    }



}
