<?php

namespace App\Tests\SmokeTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PublicSmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/horaires-et-tarifs'];
        yield ['/nous-contacter'];
        yield ['/mentions-legales'];
        yield ['/connexion'];
    }
}
