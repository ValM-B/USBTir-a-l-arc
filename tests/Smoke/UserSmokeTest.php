<?php

namespace App\Tests\Smoke;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserSmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $user = $userRepository->findOneByEmail('oceane.laine@carpentier.com');
        // simulate $testUser being logged in
        $client->loginUser($user);

        $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/profil'];
        yield ['/organigramme'];
    }
}
