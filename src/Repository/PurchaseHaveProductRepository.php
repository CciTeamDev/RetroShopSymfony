<?php

namespace App\Repository;

use App\Entity\PurchaseHaveProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PurchaseHaveProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseHaveProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseHaveProduct[]    findAll()
 * @method PurchaseHaveProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseHaveProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchaseHaveProduct::class);
    }

    // /**
    //  * @return PurchaseHaveProduct[] Returns an array of PurchaseHaveProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PurchaseHaveProduct
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
