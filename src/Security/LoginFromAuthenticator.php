<?php

namespace App\Security;

use App\Entity\Purchase;
use App\Entity\User;
use App\Service\Cart\CartService;
use App\Service\Purchase\PurchaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFromAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    private EntityManagerInterface $em;
    private array $service = [];

    public function __construct(UrlGeneratorInterface $urlGenerator,EntityManagerInterface $em,CartService $cartService,PurchaseService $purchaseService)
    {
        $this->urlGenerator = $urlGenerator;
        $this->service['Cart']=$cartService;
        $this->service['Purchase']=$purchaseService;
        $this->em = $em;
    }

    public function authenticate(Request $request): PassportInterface
    {
        $username = $request->request->get('username', '');

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->get('_csrf_token')),
            ]
        );
    }

    protected function leTest(CartService $cartService,PurchaseService $purchaseService,$user){
        
        if($user) {
            $user = $this->em->getRepository(User::class)->findOneBy(['id'=>$user->getId()]);
            $purchase = $this->em->getRepository(Purchase::class)->findOneBy(['user'=>$user,'status'=>'panier']);
            $purchaseService->checkPurchase($purchase,$user,$cartService);
        } 
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token,string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        
        $this->leTest($this->service['Cart'],$this->service['Purchase'],$token->getUser());
        // For example:
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
