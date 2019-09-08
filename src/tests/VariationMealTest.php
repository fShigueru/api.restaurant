<?php

namespace App\Tests;

use App\Entity\DiscountVariationMeal;
use App\Entity\Meal;
use App\Entity\VariationMeal;
use App\Service\VariationMealService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VariationMealTest extends WebTestCase
{
    /**
     * @throws \Exception
     */
    public function testFindByIdModelSearch()
    {
        self::bootKernel();
        $container = self::$container;

        /* @var VariationMealService $service */
        $service = $container->get('App\Service\VariationMealService');

        $variationMeal = new VariationMeal();
        $variationMeal->setPrice(25);
        $variationMeal->setDescription("Descrição refeição");
        $variationMeal->setMeal(new Meal());
        $variationMeal->setName("Nome da variação da refeição");


        $discount = new DiscountVariationMeal();
        $discount->setType("F");
        $discount->setValue(5);
        $discount->setRuleValue(25);
        $discount->setRuleInitDate(new \DateTime('2019-01-01'));
        $discount->setRuleFinalDate(new \DateTime('2020-01-01'));

        $service->discountMeal($variationMeal, $discount);
        $this->assertEquals(20, $variationMeal->getPrice(), 'Discount of 5 reais was not applied.');
    }
}
