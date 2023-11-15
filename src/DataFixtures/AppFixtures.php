<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("zh_TW");

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realTextBetween(3, 10))
                ->setContent($faker->realTextBetween(500, 1400))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setVisible($faker->boolean(80));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
