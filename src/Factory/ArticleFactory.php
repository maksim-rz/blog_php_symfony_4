<?php

namespace App\Factory;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Article|Proxy findOrCreate(array $attributes)
 * @method static Article|Proxy random()
 * @method static Article[]|Proxy[] randomSet(int $number)
 * @method static Article[]|Proxy[] randomRange(int $min, int $max)
 * @method static ArticleRepository|RepositoryProxy repository()
 * @method Article|Proxy create($attributes = [])
 * @method Article[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class ArticleFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->name,
//            'content' =>  self::faker()->realText(80),
            'description' =>  self::faker()->realText(150),
            'content' =>  self::faker()->paragraphs(
                self::faker()->numberBetween(1, 4),
                true
            ),
            'image' => self::faker()->domainName,
            'createdAt' => self::faker()->dateTimeBetween('-10 month'),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(Article $article) {})
        ;
    }

    protected static function getClass(): string
    {
        return Article::class;
    }
}
