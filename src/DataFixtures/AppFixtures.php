<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
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
        $this->createProductByCategory($manager,$faker,$categorys);
        $manager->flush();
    }

    private function createCategory($manager,$faker){
        $categorys = [];
        for($i = 0;$i <3; $i++){
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $categorys[] = $category;
        }
        $manager->flush();
        return $categorys;
    }

    private function createProductByCategory($manager,$faker,$articles){
        foreach($articles as $article){
            for($i=0;$i<10;$i++){
                //$categoryFromDB = $manager->getRepository(Category::class)->findOneBy([
                //    'name'=> $category->getName()
                //]);
                $article = new Article();
                //$article->setCategory($categoryFromDB);
                $article->setName($faker->firstName());
                $article->setInfos($faker->lastName());
                $article->setPrice($faker->randomFloat(2, 1, 50));
                $article->setCreatedAt(new DateTimeImmutable());
                $article->setPic($faker->firstName());
                $manager->persist($article);

            
            }
        }
    }
}
