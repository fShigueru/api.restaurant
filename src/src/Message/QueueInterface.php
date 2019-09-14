<?php


namespace App\Message;


Interface QueueInterface
{
    public function getContent(): string;
}