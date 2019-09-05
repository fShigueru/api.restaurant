<?php


namespace App\DataFixtures;


use App\Entity\Restaurant;
use App\Entity\RestaurantAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RestaurantFixtures extends Fixture
{

    public const RESTAURANT = 'restaurant';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $restaurantAddress = new RestaurantAddress();
        $restaurantAddress->setStreet('Rua Reboujo');
        $restaurantAddress->setNumber(910);
        $restaurantAddress->setNeighborhood('Chácara Santo Antônio (Zona Leste)');
        $restaurantAddress->setCep('03408050');
        $restaurantAddress->setLongitude('-23.550862');
        $restaurantAddress->setLatitude('-46.552003');
        $restaurantAddress->setCity('São Paulo');
        $restaurantAddress->setUf('SP');

        $restaurant = new Restaurant();
        $restaurant->setAddress($restaurantAddress);
        $restaurant->setName('Reboujo');
        $restaurant->setScore(0);

        $manager->persist($restaurant);
        $manager->flush();

        $this->addReference(self::RESTAURANT, $restaurant);
    }
}