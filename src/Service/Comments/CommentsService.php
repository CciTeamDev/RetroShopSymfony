<?php

namespace App\Service\Comments;

use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\User;

class CommentsService{
    private $entityManager;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // public function add(int $id, User $user, $note, $comment)
    // {
    //     $article = $this->entityManager->getRepository(Article::class)->findOneBy(['id' => $id]);
    //     $em = $this->entityManager;

    //     $rate = new Comments();
    //     // $rate->setNote($note);
    //     // $rate->setComment($comment);
    //     // $rate->setModerated(0);
    //     // $rate->setUser($user);
    //     // $rate->setArticle($article);
    //     // $em->persist($rate);
    //     // $em->flush();

    // }

    public function show(Article $article)
    {
        $comments = $this->entityManager->getRepository(Comments::class)->findBy(['article'=>$article]);
        // dd($ratings);
        foreach($comments as $comment){
            $array[] = [
                'user_id' => $comment->getUser(),
                'note' => $comment->getNote(),
                'comment' => $comment->getComment()
            ];
        }
        // dd($array);
        return $array;
    }
}