<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        /** @var array<array-key, Category> $categories */
        $categories = $manager->getRepository(Category::class)->findAll();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 5; ++$i) {
                $trick = new Trick();
                $trick->setCategory($category);
                $trick->setCreatedAt(new DateTime());
                $trick->setName($faker->words(rand(1, 2), true));
                $trick->setSlug($faker->slug);
                $trick->setDescription($faker->paragraphs(rand(1, 5), true));
                $trick->setFeaturedImage('jess-bailey-l3N9Q27zULw-unsplash.jpg');

                $manager->persist($trick);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}
