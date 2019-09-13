<?php


namespace App\State;


use Symfony\Component\Config\Definition\Exception\Exception;

abstract class AbstractRestaurantState implements RestaurantStateInterface
{
    public function open()
    {
        throw new Exception('Estado open não permitido');
    }

    public function close()
    {
        throw new Exception('Estado close não permitido');
    }
}