<?php

namespace App\Tests\Feature;

use App\Factory\DefaultFactoryValues;
use App\Factory\ThreadFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateThreadsTest extends BaseWebTestCase
{
    use ResetDatabase, Factories;

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have an authenticated user
        $user = $this->signIn();

        // And no threads in the db
        ThreadFactory::repository()->assertCount(0);

        // When we visit the threads page
        $this->client->request('GET', "/threads");

        $this->client->submitForm('Create Thread', DefaultFactoryValues::getDefaultThreadValues('thread', [
            'title' => 'Test Thread Title',
            'body' => 'Test Thread Body'
        ]));

        // We should be redirected back to the same page
        $this->assertResponseRedirects("/threads");

        // And the user's reply should be visible on the page
        $this->client->request('GET', "/threads");
        $this->assertStringContainsString('Test Thread Title', $this->client->getResponse()->getContent());
        $this->assertStringContainsString('Test Thread Body', $this->client->getResponse()->getContent());

        // And 1 thread should be found in the db
        ThreadFactory::repository()->assertCount(1);
    }

    /** @test */
    public function unauthenticated_users_may_not_create_threads()
    {
        ThreadFactory::repository()->assertCount(0);

        // If a guest tries to add a reply
        $this->client->request('POST', "/threads", []);

        // We should be redirected to login
        $this->assertResponseRedirects("/login");

        // And no replies should be in the db
        ThreadFactory::repository()->assertCount(0);
    }
}
