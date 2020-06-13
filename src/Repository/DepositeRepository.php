<?php

namespace App\Repository;

use App\Entity\Deposite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Deposite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deposite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deposite[]    findAll()
 * @method Deposite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepositeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deposite::class);
    }

    // /**
    //  * @return Deposite[] Returns an array of Deposite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deposite
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
