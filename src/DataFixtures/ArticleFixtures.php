<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private const NB_ARTICLES = 150;

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("zh_TW");

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realTextBetween(3, 10))
                ->setContent($faker->realTextBetween(500, 1400))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setVisible($faker->boolean(80))
                ->setCategory($this->getReference(CategoryFixtures::REF_PREFIX . $faker->numberBetween(1, CategoryFixtures::NB_CATEGORIES)));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
