<?php


namespace App\State;


class ClosedRestaurantState extends AbstractRestaurantState
{
    public function open()
    {
        return new OpenRestaurantState();
    }

}