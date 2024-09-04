<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 50;

    private const CATEGORIES_NAMES = ["Sport", "France", "International", "Économie", "Politique"];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('zh_TW');

        $categories = [];

        // --- CATEGORIES ----------------------------------------------
        foreach (self::CATEGORIES_NAMES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categories[] = $category;
        }

        // --- ARTICLES ------------------------------------------------
        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realTextBetween(9, 15))
                ->setContent($faker->realTextBetween(350, 700))
                ->setCreatedAt($faker->dateTimeBetween('-4 years'))
                ->setVisible($faker->boolean(80))
                ->setCategory($faker->randomElement($categories));

            $manager->persist($article);
        }

        // --- USERS ---------------------------------------------------
        $admin = new User();
        $admin
            ->setEmail("admin@test.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword("admin1234");

        $manager->persist($admin);

        $user = new User();
        $user
            ->setEmail("user@test.com")
            ->setPassword("test1234");

        $manager->persist($user);

        $manager->flush();
    }
}