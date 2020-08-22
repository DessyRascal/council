<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Factory\ThreadFactory;
use Doctrine\Common\Collections\Collection;

class ThreadTest extends BaseKernelTestCase
{
    /** @test */
    public function a_thread_has_an_owner()
    {
        $thread = ThreadFactory::new()->create();
        $this->assertInstanceOf(User::class, $thread->getOwner());
    }

    /** @test */
    public function a_thread_has_replies_collection()
    {
        $thread = ThreadFactory::new()->create();
        $this->assertInstanceOf(Collection::class, $thread->getReplies());
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        // DELEGATING FUNCTIONALITY TO A MODEL/ENTITY CLASS IS NOT SYMFONY'S
        // STANDARD WORKFLOW
        $this->markTestSkipped();
    }
}
