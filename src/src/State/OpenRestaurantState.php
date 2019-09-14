<?php


namespace App\State;


class OpenRestaurantState extends AbstractRestaurantState
{
    public function close()
    {
        return new ClosedRestaurantState();
    }

}