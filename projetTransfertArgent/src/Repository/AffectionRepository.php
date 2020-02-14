<?php

namespace App\Repository;

use App\Entity\Affection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Affection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affection[]    findAll()
 * @method Affection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affection::class);
    }

    // /**
    //  * @return Affection[] Returns an array of Affection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Affection
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
