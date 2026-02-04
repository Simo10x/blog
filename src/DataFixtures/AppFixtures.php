<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = [];

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setNameUser($faker->lastName());
            $user->setFirstnameUser($faker->firstName());
            $user->setEmailUser($faker->unique()->email());
            $user->setPasswordUser('password');
            $user->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setNameCat($faker->word());
            $category->setDescriptionCat($faker->sentence());

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < 100; $i++) {
            $article = new Article();
            $article->setTitleArticle($faker->sentence());
            $article->setContentArticle($faker->paragraph(5));
            $article->setImageArticle($faker->imageUrl());
            $article->setCreatedAt(new \DateTimeImmutable());

            // Relation ManyToOne -> User
            $article->setWriteBy(
                $faker->randomElement($users)
            );

            // Relation ManyToMany -> Category
            $article->addCategory(
                $faker->randomElement($categories)
            );

            $manager->persist($article);
        }

        $manager->flush();
    }
}
