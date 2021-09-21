<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    public function search($name)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :val')
            ->setParameter('val', '%'.$name.'%')
            ->orderBy('a.id', 'ASC') 
            ->getQuery()
            ->getResult()
        ;
    }


    
    public function selectCateg($name)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.name WHERE :val')
            ->setParameter('val', $name)
            ->orderBy('a.id', 'ASC') 
            ->getQuery()
            ->getResult()
        ;
    }
    
}
