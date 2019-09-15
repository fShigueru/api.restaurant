<?php


namespace App\DataFixtures;


use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MealFixtures extends Fixture implements DependentFixtureInterface
{
    public const MEAL = 'meal';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $meal = new Meal();
        $meal->setName('Bife a cavalo');
        $meal->setDescription('Bife a cavalo com arroz e feijão');
        $meal->setPosition(1);
        $meal->setImage('https://i.pinimg.com/originals/ae/a1/90/aea19010e011789e02ffc37a66b70fa0.jpg');
        $meal->setCategory($this->getReference(CategoryFixtures::CATEGORY));
        $meal->setRestaurant($this->getReference(RestaurantFixtures::RESTAURANT));

        $manager->persist($meal);
        $manager->flush();

        $this->addReference(self::MEAL, $meal);
    }

    public function getDependencies()
    {
        return array(
            RestaurantFixtures::class,
            CategoryFixtures::class,
        );
    }
}