<?php


namespace App\Service;


use App\Entity\Meal;
use App\Repository\CategoryRepository;
use App\Repository\MealRepository;
use App\Repository\RestaurantRepository;
use App\Repository\VariationMealRepository;
use Symfony\Component\HttpFoundation\Request;

class MealService
{
    /**
     * @var MealRepository
     */
    protected $mealRespository;

    /**
     * @var VariationMealRepository
     */
    protected $mealVariationRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var RestaurantRepository
     */
    protected $restaurantRepository;

    /**
     * MealService constructor.
     * @param MealRepository $mealRespository
     * @param VariationMealRepository $mealVariationRepository
     * @param CategoryRepository $categoryRepository
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(MealRepository $mealRespository, VariationMealRepository $mealVariationRepository, CategoryRepository $categoryRepository, RestaurantRepository $restaurantRepository)
    {
        $this->mealRespository = $mealRespository;
        $this->mealVariationRepository = $mealVariationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * @param int $id
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById(int $id) : array
    {
        $meal = $this->mealRespository->findById($id);
        $variationCollection = $this->mealVariationRepository->findAllByMeal($id);
        $meal['variation'] = $variationCollection;

        return $meal;
    }

    /**
     * @param Request $request
     * @return Meal $meal
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Request $request) : Meal
    {
        $category = $this->categoryRepository->find($request->get('category'));
        $restaurant = $this->restaurantRepository->find($request->get('restaurant'));

        $meal = new Meal();
        $meal->setName($request->get('name'));
        $meal->setDescription($request->get('description'));
        $meal->setPosition($request->get('position'));
        $meal->setImage($request->get('image'));
        $meal->setCategory($category);
        $meal->setRestaurant($restaurant);
        $this->mealRespository->create($meal);

        return $meal;
    }

}