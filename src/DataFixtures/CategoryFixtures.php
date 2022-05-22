<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 5; ++$i) {
            $category = new Category();
            $category->setName($faker->words(rand(1, 4), true));
            $category->setSlug($faker->slug);
            $category->setColor($faker->hexColor());
            $manager->persist($category);
        }

        $manager->flush();
    }
}
