<?php

namespace App\Factory;

use App\Entity\Reply;
use App\Repository\ReplyRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Reply|Proxy findOrCreate(array $attributes)
 * @method static Reply|Proxy random()
 * @method static Reply[]|Proxy[] randomSet(int $number)
 * @method static Reply[]|Proxy[] randomRange(int $min, int $max)
 * @method static ReplyRepository|RepositoryProxy repository()
 * @method Reply|Proxy create($attributes = [])
 * @method Reply[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class ReplyFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return array_merge(
            DefaultFactoryValues::getDefaultReplyValues(),
            [
                'owner' => UserFactory::new(),
                'thread' => ThreadFactory::new(),
            ]
        );
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(Reply $reply) {})
        ;
    }

    protected static function getClass(): string
    {
        return Reply::class;
    }
}
