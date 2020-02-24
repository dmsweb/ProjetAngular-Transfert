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
    
    public function findComptAffecter($compteId):array
    {
        $req = $this->createQueryBuilder('a')
            ->Where('a.compteId > :compteId')
            ->setParameter('compteId', $compteId);


            $query = $req->getQuery();

    return $query->execute();
            
        
    }
    

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
