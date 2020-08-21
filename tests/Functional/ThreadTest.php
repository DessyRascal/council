<?php

namespace App\Tests\Feature\Functional;

use App\Entity\User;
use App\Factory\ReplyFactory;
use App\Factory\ThreadFactory;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ThreadTest extends KernelTestCase
{
    use ResetDatabase, Factories;

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
