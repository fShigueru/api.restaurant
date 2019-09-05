<?php


namespace App\DataFixtures;


use App\Entity\VariationMeal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VariationMealFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $variationMeal = new VariationMeal();
        $variationMeal->setName('Serve uma pessoa');
        $variationMeal->setDescription('Serve uma pessoa');
        $variationMeal->setPrice(15);
        $variationMeal->setMeal($this->getReference(MealFixtures::MEAL));

        $variationMeal2 = new VariationMeal();
        $variationMeal2->setName('Serve duas pessoa');
        $variationMeal2->setDescription('Serve duas pessoa');
        $variationMeal2->setPrice(23);
        $variationMeal2->setMeal($this->getReference(MealFixtures::MEAL));

        $manager->persist($variationMeal);
        $manager->persist($variationMeal2);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MealFixtures::class,
        );
    }
}