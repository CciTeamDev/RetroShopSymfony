<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    #[Route('/compte/adresse', name: 'mes_adresses')]
    public function index(): Response
    {
        return $this->render('adresse/adresse.html.twig');
    }

    #[Route('/compte/ajouter_adresse', name: 'ajouter_adresse')]
    public function new(Request $request): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class,$adresse);

        $form->handleRequest($request);
        if($request->isMethod('GET')){
            $request->getSession()->set('referer', $request->headers->get('referer'));
        }

        if($form->isSubmitted() && $form->isValid()){

            $adresse->setUser($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();


            return $this->redirect($request->getSession()->get('referer'));
        }
        return $this->render('adresse/adresse_form.html.twig',[
            'form'=> $form->createView()
        ]);
    }

    #[Route('/compte/delete_adresse/{id}', name: 'account_address_delete')]
    public function delete($id): Response
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);

        if($adresse &&  $adresse->getUser() == $this->getUser()) {
            $this->entityManager->remove($adresse);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('mes_adresses');
    }

    
}
