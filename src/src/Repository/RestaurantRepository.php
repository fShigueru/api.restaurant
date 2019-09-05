<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function findAllCollection()
    {
        return $this->createQueryBuilder('r')
            ->select('r.id ,r.name, r.name, r.slug, r.score, a.street, a.number, a.neighborhood, a.cep, a.longitude, a.latitude, a.city, a.uf')
            ->leftJoin('r.address', 'a')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findCollection($id)
    {
        return $this->createQueryBuilder('r')
            ->select('r.id ,r.name, r.name, r.slug, r.score, a.street, a.number, a.neighborhood, a.cep, a.longitude, a.latitude, a.city, a.uf')
            ->andWhere('r.id = :id')
            ->leftJoin('r.address', 'a')
            ->setParameter('id', $id)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
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
    public function findOneBySomeField($value): ?Restaurant
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
