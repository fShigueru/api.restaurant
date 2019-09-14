<?php

namespace App\Service;

use App\Repository\MealRepository;
use App\Repository\RestaurantRepository;
use App\Repository\VariationMealRepository;
use App\State\RestaurantState;
use Doctrine\Common\Collections\ArrayCollection;

class RestaurantService
{

    /**
     * @var RestaurantRepository
     */
    protected $restaurantRepository;

    /**
     * @var MealRepository
     */
    protected $mealRespository;

    /**
     * @var VariationMealRepository
     */
    protected $mealVariationRepository;

    /**
     * RestaurantService constructor.
     * @param RestaurantRepository $restaurantRepository
     * @param MealRepository $mealRespository
     * @param VariationMealRepository $mealVariationRepository
     */
    public function __construct(RestaurantRepository $restaurantRepository, MealRepository $mealRespository, VariationMealRepository $mealVariationRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->mealRespository = $mealRespository;
        $this->mealVariationRepository = $mealVariationRepository;
    }


    /**
     * @return array
     */
    public function findAll(): array
    {
        $restaurantCollection = new ArrayCollection();
        foreach ($this->restaurantRepository->findAllCollection() as $restaurant) {
            foreach ($this->mealRespository->findAllByRestaurant($restaurant['id']) as $key => $meal) {
                $variationCollection = $this->mealVariationRepository->findAllByMeal($meal['id']);
                $meal['variation'] = $variationCollection;
                $restaurant['meal'][$key] = $meal;
            }
            $restaurantCollection->add($restaurant);
        }

        return $restaurantCollection->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id) : array
    {
        $restaurant = $this->restaurantRepository->findCollection($id);
        foreach ($this->mealRespository->findAllByRestaurant($restaurant['id']) as $key => $meal) {
            $variationCollection = $this->mealVariationRepository->findAllByMeal($meal['id']);
            $meal['variation'] = $variationCollection;
            $restaurant['meal'][$key] = $meal;
        }
        return $restaurant;
    }

    /**
     * @param int $id
     * @return RestaurantState
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function state(int $id) : RestaurantState
    {
        $restaurant = $this->restaurantRepository->find($id);
        $state = new RestaurantState($restaurant->getState());
        if ($state->isOpen()) {
            $state->close();
            $restaurant->setState($state->isOpen());
        } else {
            $state->open();
            $restaurant->setState($state->isOpen());
        }

        $this->restaurantRepository->update($restaurant);
        return $state;
    }
}