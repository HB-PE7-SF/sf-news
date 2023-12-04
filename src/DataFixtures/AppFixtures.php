<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_CATEGORIES = 15;
    private const NB_ARTICLES = 150;

    public function __construct(
        private string $adminEmail
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $regularUser = new User();
        $regularUser
            ->setEmail('regular@mycorp.info')
            ->setPassword('test1234');

        $manager->persist($regularUser);

        $adminUser = new User();
        $adminUser
            ->setEmail($this->adminEmail)
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword('admin1234');

        $manager->persist($adminUser);

        $users = [$regularUser, $adminUser];

        $categories = [];

        for ($i = 0; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category->setName($faker->realTextBetween(3, 10));

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realTextBetween(3, 10))
                ->setContent($faker->realTextBetween(500, 1400))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setVisible($faker->boolean(80))
                ->setCategory($faker->randomElement($categories))
                ->setAuthor($faker->randomElement($users));

            $manager->persist($article);
        }

        $apiToken = new ApiToken();
        $apiToken->setToken("51ohFpI4htIkmk8oYzzpL6xVSC3");
        $manager->persist($apiToken);

        $manager->flush();
    }
}
