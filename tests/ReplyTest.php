<?php

namespace App\Tests;

use App\Entity\User;
use App\Factory\ReplyFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReplyTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = ReplyFactory::new()->create();
        self::assertInstanceOf(User::class, $reply->getOwner());
    }
}
