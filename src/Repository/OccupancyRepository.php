<?php

namespace App\Repository;

use App\Entity\Occupancy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Occupancy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Occupancy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Occupancy[]    findAll()
 * @method Occupancy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OccupancyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Occupancy::class);
    }

    // /**
    //  * @return Occupancy[] Returns an array of Occupancy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Occupancy
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
