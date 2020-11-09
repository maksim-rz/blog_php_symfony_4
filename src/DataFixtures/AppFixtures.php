<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        CategoryFactory::new()->createMany(10);
        ArticleFactory::new()->createMany(50, function () {
            return [
                'categories' => CategoryFactory::random(),
            ];
        });
        $manager->flush();
    }
}
