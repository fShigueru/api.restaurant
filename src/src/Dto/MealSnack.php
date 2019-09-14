<?php


namespace App\Dto;


use App\Entity\Meal;

class MealSnack implements MealInterface
{
    /* @var \App\Entity\Meal */
    private $meal;

    /**
     * @param Meal $meal
     */
    public function meal(Meal $meal)
    {
        $this->meal = $meal;
    }

    /**
     * @return string
     */
    public function message()
    {
        return "Creating Snack Meal";
    }

}