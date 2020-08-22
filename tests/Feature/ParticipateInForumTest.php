<?php

namespace App\Tests\Feature;

use App\Factory\DefaultFactoryValues;
use App\Factory\ReplyFactory;
use App\Factory\ThreadFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ParticipateInForumTest extends BaseWebTestCase
{
    use ResetDatabase, Factories;

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $user = $this->signIn();

        // And an existing thread
        $thread = ThreadFactory::new(['owner' => $user, 'title' => 'Test Title', ])->create();

        // With 0 replies
        ReplyFactory::repository()->assertCount(0);

        // When we visit the threads page
        $this->client->request('GET', "/threads/{$thread->getId()}");

        // And the user adds a valid reply
        $crawler = $this->client->submitForm('Post', DefaultFactoryValues::getDefaultReplyValues('reply', [
            'body' => 'Test Reply Body'
        ]));

        // We should be redirected back to the same page
        $this->assertResponseRedirects("/threads/{$thread->getId()}");

        // And the user's reply should be visible on the page
        $this->client->request('GET', "/threads/{$thread->getId()}");
        $this->assertStringContainsString('Test Reply Body', $this->client->getResponse()->getContent());

        // And 1 reply should be found in the db
        ReplyFactory::repository()->assertCount(1);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        // Given we have a thread
        $thread = ThreadFactory::new(['title' => 'Test Title', ])->create();

        // With 0 replies
        ReplyFactory::repository()->assertCount(0);

        // If a guest tries to add a reply
        $this->client->request('POST', "/threads/{$thread->getId()}", []);

        // We should be redirected to login
        $this->assertResponseRedirects("/login");

        // And no replies should be in the db
        ReplyFactory::repository()->assertCount(0);
    }
}
