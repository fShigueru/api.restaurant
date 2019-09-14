<?php

namespace App\Repository;

use App\Entity\VariationMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VariationMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method VariationMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method VariationMeal[]    findAll()
 * @method VariationMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariationMealRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VariationMeal::class);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findAllByMeal(int $id)
    {
        return $this->createQueryBuilder('v')
            ->select('v.id, v.name, v.description, v.price')
            ->leftJoin('v.meal', 'm')
            ->andWhere('m.id = :mealId')
            ->setParameter('mealId', $id)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return $this->createQueryBuilder('v')
            ->select('v.id, v.name, v.description, v.price')
            ->andWhere('v.id = :id')
            ->setParameter('id', $id)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByIdModelSearch(int $id)
    {
        return $this->createQueryBuilder('v')
            ->select('v.id, v.name, v.description, v.price, 
                            m.id as mealId, m.name as mealName, m.description mealDescription, m.image, m.position, m.slug, 
                            c.name as categoryName, c.slug as categorySlug, c.status, 
                            r.id as restaurantId, r.name as restaurantName, r.slug as restaurantSlug, r.score, a.street, a.number, a.neighborhood, a.cep, a.city, a.uf'
            )
            ->addSelect('CONCAT(a.longitude, \' \', a.latitude) AS location')
            ->leftJoin('v.meal', 'm')
            ->leftJoin('m.category', 'c')
            ->leftJoin('m.restaurant', 'r')
            ->leftJoin('r.address', 'a')
            ->andWhere('v.id = :id')
            ->setParameter('id', $id)
            ->orderBy('v.price', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param VariationMeal $variationMeal
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(VariationMeal $variationMeal) : void
    {
        $this->_em->persist($variationMeal);
        $this->_em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update() : void
    {
        $this->_em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(VariationMeal $variationMeal) : void
    {
        $this->_em->remove($variationMeal);
        $this->_em->flush();
    }
}
