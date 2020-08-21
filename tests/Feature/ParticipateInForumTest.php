<?php

namespace App\Tests\Feature;

use App\Factory\ReplyFactory;
use App\Factory\ThreadFactory;
use App\Factory\UserFactory;
use App\Repository\ReplyRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ParticipateInForumTest extends WebTestCase
{
    use ResetDatabase, Factories;

    private $client;

    protected function setUp()
    {
        parent::setUp();

        static::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $user = UserFactory::new()->create();
        $this->client->loginUser($user->object());

        // And an existing thread
        $thread = ThreadFactory::new(['owner' => $user, 'title' => 'Test Title', ])->create();

        // When the user adds a reply to the thread
        $this->client->request('POST', "/threads/{$thread->getId()}/replies", [
            'body' => 'Test Reply Body'
        ]);

        $this->assertResponseRedirects("/threads/{$thread->getId()}");

        // Then their reply should be visible on the page
        $this->client->request('GET', "/threads/{$thread->getId()}");

        $this->assertStringContainsString('Test Reply Body', $this->client->getResponse()->getContent());
    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $thread = ThreadFactory::new(['title' => 'Test Title', ])->create();

        $this->client->request('POST', "/threads/{$thread->getId()}/replies", []);

        $this->assertResponseRedirects("/login");
        ReplyFactory::repository()->assertCount(0);
    }
}
