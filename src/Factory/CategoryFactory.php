<?php

namespace App\Factory;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Category|Proxy findOrCreate(array $attributes)
 * @method static Category|Proxy random()
 * @method static Category[]|Proxy[] randomSet(int $number)
 * @method static Category[]|Proxy[] randomRange(int $min, int $max)
 * @method static CategoryRepository|RepositoryProxy repository()
 * @method Category|Proxy create($attributes = [])
 * @method Category[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->realText(20),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(Category $category) {})
        ;
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}
