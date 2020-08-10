<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\BaseFactory;
use App\Factory\ReplyFactory;
use App\Factory\ThreadFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = UserFactory::new(['email' => 'admin@forum.test', 'roles' => ['ROLE_ADMIN']])->create();
        $users = UserFactory::new()->createMany(10);

        $threads = ThreadFactory::new()->createMany(100, function() {
            return [
                'user' => UserFactory::random()
            ];
        });

        $replies = ReplyFactory::new()->createMany(500, function() {
            return [
                'user' => UserFactory::random(),
                'thread' => ThreadFactory::random()
            ];
        });
    }
}
