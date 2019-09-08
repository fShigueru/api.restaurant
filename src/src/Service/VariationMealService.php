<?php


namespace App\Service;


use App\Entity\DiscountVariationMeal;
use App\Entity\Meal;
use App\Entity\VariationMeal;
use App\Repository\CategoryRepository;
use App\Repository\MealRepository;
use App\Repository\RestaurantRepository;
use App\Repository\VariationMealRepository;
use Symfony\Component\HttpFoundation\Request;

class VariationMealService
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
        return $this->mealVariationRepository->findById($id);
    }

    public function findByIdModelSearch(int $id) : array
    {
        return $this->mealVariationRepository->findByIdModelSearch($id);
    }

    /**
     * @param Request $request
     * @return VariationMeal
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Request $request) : VariationMeal
    {
        $meal = $this->mealRespository->find($request->get('meal'));

        $variation = new VariationMeal();
        $variation->setName($request->get('name'));
        $variation->setDescription($request->get('description'));
        $variation->setPrice($request->get('price'));
        $variation->setMeal($meal);
        $this->mealVariationRepository->create($variation);

        return $variation;
    }

    /**
     * @param VariationMeal $variationMeal
     * @param DiscountVariationMeal $discount
     * @throws \Exception
     */
    public function discountMeal(VariationMeal $variationMeal, DiscountVariationMeal $discount) : void
    {
        $now = new \DateTime('now');
        if (
            ($now >= $discount->getRuleInitDate() && $now <= $discount->getRuleFinalDate()) &&
            ($variationMeal->getPrice() <= $discount->getRuleValue())
        ){
            $discountValue = ($variationMeal->getPrice() - $discount->getValue());
            $variationMeal->setPrice($discountValue);
        }
    }

}