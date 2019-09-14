<?php


namespace App\Decorator;

use App\Entity\VariationMeal;

class VariationMealDecorator
{

    /* @var VariationMeal */
    protected $variationMeal;

    /**
     * @var string
     */
    protected $additional;

    /**
     * VariationMealDecorator constructor.
     * @param VariationMeal $variationMeal
     * @param string $additional
     */
    public function __construct(VariationMeal $variationMeal, string $additional)
    {
        $this->variationMeal = $variationMeal;
        $this->additional = $additional;
        $this->additionalDescription();
    }

    protected function additionalDescription()
    {
        $replace = sprintf('%s, adicional: %s', $this->variationMeal->getDescription(), $this->additional);
        $this->variationMeal->setDescription($replace);
    }
}