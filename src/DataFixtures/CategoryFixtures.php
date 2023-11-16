<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const NB_CATEGORIES = 15;
    public const REF_PREFIX = 'CATEGORYREF_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("zh_TW");

        for ($i = 1; $i <= self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category->setName($faker->realTextBetween(3, 10));

            $manager->persist($category);
            $this->addReference(self::REF_PREFIX . $i, $category);
        }

        $manager->flush();
    }
}