<?php

namespace App\Repository;

use App\Entity\ListeBatiments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListeBatiments|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeBatiments|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeBatiments[]    findAll()
 * @method ListeBatiments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeBatimentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeBatiments::class);
    }

    // /**
    //  * @return ListeBatiments[] Returns an array of ListeBatiments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListeBatiments
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
