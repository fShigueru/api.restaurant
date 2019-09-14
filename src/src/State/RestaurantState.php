<?php


namespace App\State;


class RestaurantState
{
    private $state;

    public function __construct(RestaurantStateInterface $state)
    {
        $this->setState($state);
    }

    public function isOpen()
    {
        return $this->state instanceof OpenRestaurantState;
    }

    public function open()
    {
        $this->setState($this->state->open());
    }

    public function close()
    {
        $this->setState($this->state->close());
    }

    private function setState(RestaurantStateInterface $state)
    {
        $this->state = $state;
    }
}
