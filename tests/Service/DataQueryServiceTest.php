<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DataQueryServiceTest extends WebTestCase
{
    private const SEARCH = [
        [
            "search" => "Denis",
            "result" => 1
        ],
        [
            "search" => "tte",
            "result" => 3
        ],
        [
            "search" => "Valérie",
            "result" => 0
        ],

    ];

    public function testSomething(): void
    {
        
        $client = static::createClient();
        foreach ( self::SEARCH as $search) {
      
           
           
            $crawler = $client->request('GET', '/api/users?search='.$search["search"]);
            dd($crawler);
            $this->assertJson($client->getResponse()->getContent());
            
            $this->assertEquals($search["result"], $crawler->filter('html:contains('.$search["search"].')')->count());
            // $this->assertResponseIsSuccessful();
            // $this->assertJson($client->getResponse()->getContent());

            // // Parsez la réponse JSON
            // $responseData = json_decode($client->getResponse()->getContent(), true);
            // // Vérifiez le nombre d'utilisateurs correspondant à la recherche
            // $this->assertCount($search["result"], $responseData);
        }

    }
}
