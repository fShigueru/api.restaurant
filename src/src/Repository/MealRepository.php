<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findAllByRestaurant(int $id)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id, m.name, m.description, m.image, m.position, m.slug, 
            c.name as categoryName, c.slug as categorySlug, c.status')
            ->leftJoin('m.category', 'c')
            ->leftJoin('m.restaurant', 'r')
            ->andWhere('r.id = :restaurantId')
            ->setParameter('restaurantId', $id)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById(int $id)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id, m.name, m.description, m.image, m.position, m.slug, 
            c.name as categoryName, c.slug as categorySlug, c.status')
            ->leftJoin('m.category', 'c')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param Meal $meal
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Meal $meal)
    {
        $this->_em->persist($meal);
        $this->_em->flush();
    }
}