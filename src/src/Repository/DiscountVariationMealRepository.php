<?php

namespace App\Repository;

use App\Entity\DiscountVariationMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DiscountVariationMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountVariationMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountVariationMeal[]    findAll()
 * @method DiscountVariationMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountVariationMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountVariationMeal::class);
    }

    // /**
    //  * @return DiscountVariationMeal[] Returns an array of DiscountVariationMeal objects
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
    public function findOneBySomeField($value): ?DiscountVariationMeal
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
