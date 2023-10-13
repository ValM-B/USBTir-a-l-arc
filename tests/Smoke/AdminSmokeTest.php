<?php

namespace App\Tests\Smoke;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminSmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $admin = $userRepository->findOneByEmail('raymond43@sanchez.com');
        // simulate $testUser being logged in, with the good firewall
        $client->loginUser($admin, "admin");

        $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/admin35786/'];
        yield ['/admin35786/utilisateurs/'];
        yield ['/admin35786/api/users'];
        yield ['/admin35786/utilisateurs/new'];
        yield ['/admin35786/utilisateurs/1'];
        yield ['/admin35786/cours/'];
        yield ['/admin35786/cours/new'];
        yield ['/admin35786/cours/1'];
        yield ['/admin35786/cours-types/'];
        yield ['/admin35786/cours-types/new'];
        yield ['/admin35786/tarifs/'];
        yield ['/admin35786/tarifs/new'];
        yield ['/admin35786/tarifs/1'];
    }
}
