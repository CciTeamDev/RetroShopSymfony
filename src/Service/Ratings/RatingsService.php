<?php

namespace App\Service\Ratings;

use App\Entity\Article;
use App\Entity\Ratings;
use App\Entity\User;

class RatingsService{
    private $entityManager;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(int $id, User $user, $note, $comment)
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['id' => $id]);
        $em = $this->entityManager;

        $rate = new Ratings();
        $rate->setNote($note);
        $rate->setComment($comment);
        $rate->setModerated(0);
        $rate->setUser($user);
        $rate->setArticle($article);
        $em->persist($rate);
        $em->flush();

    }

    public function show(Article $article)
    {
        $ratings = $this->entityManager->getRepository(Ratings::class)->findBy(['article'=>$article]);
        // dd($ratings);
        foreach($ratings as $rating){
            $array[] = [
                'user_id' => $rating->getUser(),
                'note' => $rating->getNote(),
                'comment' => $rating->getComment()
            ];
        }
        // dd($array);
        return $array;
    }
}