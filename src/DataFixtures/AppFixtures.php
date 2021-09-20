<?php

namespace App\DataFixtures;

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

    private function createProductByCategory($manager,$faker,$categorys){
        foreach($categorys as $category){
            for($i=0;$i<10;$i++){
                $categoryFromDB = $manager->getRepository(Category::class)->findOneBy([
                    'name'=> $category->getName()
                ]);
                $article = new Article();
                $article->setCategory($categoryFromDB);
                $article->setContent($faker->paragraph(3,true));
                $article->setCreatedAt(new DateTimeImmutable());
                $article->setTitle($faker->realText(10,1));
                $manager->flush();
            }
        }
    }
}
