<?php


namespace App\State;


interface RestaurantStateInterface
{
    public function open();
    public function close();
}