<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public const CATEGORY = 'category';


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Brasileira');
        $category->setStatus(true);
        $manager->persist($category);
        $manager->flush();

        $this->addReference(self::CATEGORY, $category);
    }
}