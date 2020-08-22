<?php

namespace App\Tests\Feature;

use App\Factory\ReplyFactory;
use App\Factory\ThreadFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ThreadsTest extends BaseWebTestCase
{
    use ResetDatabase, Factories;

    private $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = ThreadFactory::new(['title' => 'Test Title'])->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->client->request('GET', '/threads');
        $this->assertContains($this->thread->getTitle(), $this->client->getResponse()->getContent());
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $this->client->request('GET', '/threads/' . $this->thread->getId());
        $this->assertContains($this->thread->getTitle(), $this->client->getResponse()->getContent());
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $this->thread = $this->thread->refresh();
        $reply = ReplyFactory::new()->create(['thread' => $this->thread, 'body' => 'Test Body']);
        $this->client->request('GET', '/threads/' . $this->thread->getId());
        $this->assertContains($reply->getBody(), $this->client->getResponse()->getContent());
    }
}
