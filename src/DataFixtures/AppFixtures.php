<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comments;
use App\Entity\Purchase;
use App\Entity\PurchaseHaveProduct;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        $faker = Faker\Factory::create();
        // $product = new Product();
        // $manager->persist($product);

        $categorys = $this-> createCategory($manager,$faker);
        $user = $this->createUser($manager,$faker);
        $article = $this->createArticleByCategory($manager,$faker,$categorys);
        $this->createCommentByArticle($manager,$faker,$article,$user);
        $this->createAdresseByUser($manager,$faker,$user);
        $purch = $this->createPurchaseByUser($manager,$user);
        $this->createPanierByPurchase($manager,$faker,$article,$purch);
        $manager->flush();
    }

    private function createCategory($manager,$faker){
        $categorys = [];
        for($i = 0;$i <10; $i++){
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);
            $categorys[] = $category;
        }
        $manager->flush();
        return $categorys;
    }

    private function createUser($manager,$faker){
        $users=[];
        for($i=0;$i<5;$i++){
            $user = new User();
            $user->setUsername($faker->word());
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($faker->word());
            $user->setNom($faker->firstName());
            $user->setPrenom($faker->lastName());
            $user->setGenre($faker->word());
            $user->setDateNaissance($faker->dateTime('now'));
            $user->setEmail($faker->safeEmail());
            $manager->persist($user);
            $users[] = $user;
        }
        $manager->flush();
        return $users;
    }

    private function createArticleByCategory($manager,$faker,$category){
        $article = [];
        foreach($category as $articleInCateg){
            $categ = $articleInCateg;
            for($i=0;$i<10;$i++){

                $articleInCateg = new Article();
                $articleInCateg->setName($faker->firstName());
                $articleInCateg->setInfos($faker->lastName());
                $articleInCateg->setPrice($faker->randomFloat(2, 1, 50));
                $articleInCateg->setCreatedAt(new DateTimeImmutable());
                $articleInCateg->setUpdatedAt(new DateTimeImmutable());
                $articleInCateg->setImageName($faker->firstName());
                $articleInCateg->addCategory($categ);
                $manager->persist($articleInCateg);
                $article[] = $articleInCateg;
            
            }
        }
        $manager->flush();
        return $article;
    }

    

    private function createCommentByArticle($manager,$faker,$articles,$users){
        foreach($users as $user) {
            $idUser = $user;
            $this->boucleCreateCommByArt($manager,$faker,$articles,$idUser);
        }
        $manager->flush();
    }

    private function boucleCreateCommByArt($manager,$faker,$articles,$idUser){
        foreach($articles as $article){
                $idArticle = $article;
                
                
                
                $commentOnArticle = new Comments();
                $commentOnArticle->setArticle($idArticle);
                $commentOnArticle->setUser($idUser);
                $commentOnArticle->setContent($faker->word());
                $commentOnArticle->setCreatedAt(new DateTimeImmutable());
                $commentOnArticle->setNote($faker->numberBetween(1,5));
                $commentOnArticle->setModerate(1);
                $manager->persist($commentOnArticle);
            
        }
    }

    private function createAdresseByUser($manager,$faker,$users){
        foreach($users as $user) {
            $idUser = $user;
            $userAdresse = new Adresse();
            $userAdresse->setUser($idUser);
            $userAdresse->setName($faker->cityPrefix()); //nom de l'adresse
            $userAdresse->setFirstName($faker->firstName());
            $userAdresse->setCompany($faker->word());
            $userAdresse->setAdresse($faker->streetName());
            $userAdresse->setCp($faker->numberBetween(01000,99000));
            $userAdresse->setVille($faker->city());
            $userAdresse->setPays($faker->country());
            $userAdresse->setTelephone($faker->numberBetween(33100000000,33999999999));
            $userAdresse->setLastname($faker->lastName());
            $manager->persist($userAdresse);

        }
        $manager->flush();
    }

    private function createPurchaseByUser($manager,$users){
        $purchases=[];
        foreach($users as $user){
            $idUser = $user;
            $purchase = new Purchase();
            $purchase->setUser($idUser);
            $purchase->setCreatedAt(new DateTimeImmutable());
            $purchase->setStatus('panier');
            $purchase->setTotal(0);
            $purchases[]=$purchase;
            $manager->persist($purchase);
        }
        $manager->flush();
        return $purchases;
    }

    private function createPanierByPurchase($manager,$faker,$articles,$purchases){
        foreach($purchases as $purchase){
            $purch = $purchase;
            for($j=0;$j<5;$j++){
                $panier = new PurchaseHaveProduct();
                $panier->setPurchase($purch);
                $panier->setArticle($articles[$j]);
                $panier->setQuantity($faker->numberBetween(1,5));
                $manager->persist($panier);
            }
            
        }
        $manager->flush();
    }
}
