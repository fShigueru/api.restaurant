<?php

namespace App\Repository;

use App\Entity\RestaurantAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RestaurantAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method RestaurantAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method RestaurantAddress[]    findAll()
 * @method RestaurantAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantAddressRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RestaurantAddress::class);
    }

    // /**
    //  * @return RestaurantAddress[] Returns an array of RestaurantAddress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RestaurantAddress
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
