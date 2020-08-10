<?php

namespace App\Factory;

use App\Entity\Thread;
use App\Repository\ThreadRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Thread|Proxy findOrCreate(array $attributes)
 * @method static Thread|Proxy random()
 * @method static Thread[]|Proxy[] randomSet(int $number)
 * @method static Thread[]|Proxy[] randomRange(int $min, int $max)
 * @method static ThreadRepository|RepositoryProxy repository()
 * @method Thread|Proxy create($attributes = [])
 * @method Thread[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class ThreadFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        $userRepository = UserFactory::repository();
        $user = $userRepository->first();

        return [
            'title' => self::faker()->words(3, true),
            'body' => self::faker()->paragraph(3, true),
            'user' => UserFactory::new()
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(Thread $thread) {})
        ;
    }

    protected static function getClass(): string
    {
        return Thread::class;
    }
}
