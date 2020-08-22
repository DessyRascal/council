<?php

namespace App\Tests\Feature;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BaseWebTestCase extends WebTestCase
{
    protected $client;

    protected function setUp()
    {
        parent::setUp();

        static::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: UserFactory::new()->create();

        $this->client->loginUser($user->object());

        return $user;
    }
}
