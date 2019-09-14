<?php


namespace App\Dto;


use App\Entity\Meal;

interface MealInterface
{
    public function meal(Meal $meal);
    public function message();
}