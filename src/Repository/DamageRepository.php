<?php

namespace App\Repository;

use App\Entity\Damage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Damage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Damage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Damage[]    findAll()
 * @method Damage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Damage::class);
    }

    // /**
    //  * @return Damage[] Returns an array of Damage objects
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
    public function findOneBySomeField($value): ?Damage
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
