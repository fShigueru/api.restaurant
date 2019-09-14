<?php


namespace App\Factory;


class MealFactory
{
    /**
     * @param string $type
     * @return mixed
     */
    public static function build ($type = '') {

        if($type == '') {
            throw new Exception('Invalid Meal Type.');
        } else {

            $className = 'App\Dto\Meal'.ucfirst($type);

            // Assuming Class files are already loaded using autoload concept
            if(class_exists($className)) {
                return new $className();
            } else {
                throw new Exception('Meal type not found.');
            }
        }
    }
}