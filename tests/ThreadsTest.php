<?php

namespace App\Tests;

use App\Factory\ThreadFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ThreadsTest extends WebTestCase
{
    use ResetDatabase, Factories;

    public function test_a_user_can_view_all_threads()
    {
        $thread = ThreadFactory::new()->create(['title' => 'Test Title']);
        static::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', '/threads');
        self::assertContains($thread->getTitle(), $client->getResponse()->getContent());
    }

    public function test_a_user_can_view_a_single_thread()
    {
        $thread = ThreadFactory::new()->create(['title' => 'Test Title']);
        static::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', '/threads/' . $thread->getId());
        self::assertContains($thread->getTitle(), $client->getResponse()->getContent());
    }
}
