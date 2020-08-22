<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Factory\ReplyFactory;


class ReplyTest extends BaseKernelTestCase
{
    /** @test */
    public function it_has_an_owner()
    {
        $reply = ReplyFactory::new()->create();
        $this->assertInstanceOf(User::class, $reply->getOwner());
    }
}
