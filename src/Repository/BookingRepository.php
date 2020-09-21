<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * Gets bookings by startdate and enddate
     * 
     * 
     * @param array $bookingFrom
     * @param array $bookingTillƒ
     * @return array
     */
    public function getVacanciesbydate($bookingFrom = [], $bookingTill = [])
    {
        //select * from booking
        //where
        //bookingfrom <= '2019-05-01'
        //AND
        //bookingtill >= '2019-05-30'
        //or
        //bookingfrom >= '2019-05-01'
        //AND
        //bookingtill <= '2019-05-30'

        $vancancies =  $this->createQueryBuilder('b')
            ->andWhere('b.bookingfrom <= :bookingfrom AND b.bookingtill >= :bookingtill AND b.deleted = 0 AND b.hidden = 0')
            ->orWhere('b.bookingfrom >= :bookingfrom AND b.bookingtill <= :bookingtill')
            ->setParameter('bookingtill', $bookingTill)
            ->setParameter('bookingfrom', $bookingFrom)
            ->getQuery()
            ->execute();
        $vacanceIds = [];
        foreach ($vancancies as $vancance) {
            if (!in_array($vancance->getBookedRoom()->getId(), $vacanceIds)) {
                $vacanceIds[] = $vancance->getBookedRoom()->getId();
            }
        }
        return $vacanceIds;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function showBookingsInFuture()
    {
        $startdate = new \DateTime(date('Y-m-d') . '23:59:59');
        return $this->createQueryBuilder('b')
            ->andWhere('b.bookingtill > :bookingfrom')
            ->setParameter('bookingfrom', $startdate)
            ->orderBy('b.bookingfrom', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function showBookedRoomsbymonth()
    {
        $startdate = new \DateTime(date('Y-m') . '-01');
        $enddate = new \DateTime(date('Y-m') . '-30');
        return $this->createQueryBuilder('b')
            ->andWhere('b.bookingfrom >= :bookingfrom AND b.bookingtill <= :bookingtill')
            ->setParameter('bookingfrom', $startdate)
            ->setParameter('bookingtill', $enddate)
            ->orderBy('b.bookingfrom', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function findCheckInsToday()
    {
        $startdate = new \DateTime(date('Y-m-d') . '00:00:00');
        $enddate = new \DateTime(date('Y-m-d') . '23:59:59');
        return $this->createQueryBuilder('b')
            ->andWhere('b.bookingfrom >= :bookingfrom AND b.bookingfrom <= :bookingtill')
            ->setParameter('bookingfrom', $startdate)
            ->setParameter('bookingtill', $enddate)
            ->orderBy('b.bookingfrom', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function findCheckOutsToday()
    {
        $startdate = new \DateTime(date('Y-m-d') . '00:00:00');
        $enddate = new \DateTime(date('Y-m-d') . '23:59:59');
        return $this->createQueryBuilder('b')
            ->andWhere('b.bookingtill >= :bookingfrom AND b.bookingtill <= :bookingtill')
            ->setParameter('bookingfrom', $startdate)
            ->setParameter('bookingtill', $enddate)
            ->orderBy('b.bookingfrom', 'ASC')
            ->getQuery()
            ->execute();
    }
    /**
     * @param $price
     * @return Product[]
     */
    public function findAllGreaterThanPrice($price): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
