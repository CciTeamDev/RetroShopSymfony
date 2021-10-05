<?php

namespace App\Service\Category;

use App\Entity\Category;

class CategoryService{

    private $entityManager;
    public function __construct($entityManager)
    {
          $this->entityManager=$entityManager;
    }

    public function getAllCategs(){
        $categs =  $this->entityManager->getRepository(Category::class)->findAll();
        //dd($categs);
        $cat= [];
        foreach($categs as $categ) {
            $cat[] = $categ->getName();
        }
        return $cat;
    }
}