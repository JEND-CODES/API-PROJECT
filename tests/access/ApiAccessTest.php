<?php

namespace App\Func;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\ConsumerRepository;

class ApiAccessTest extends WebTestCase
{

    public function testConsumerApiAccess()
    {
        $client = static::createClient();

        $consumerRepo = static::$container->get(ConsumerRepository::class);

        $consumer = $consumerRepo->findOneByEmail('admin.free@test.com');

        $client->loginUser($consumer);

        $crawler = $client->request('GET', '/api');

        $this->assertResponseIsSuccessful();

        $crawler = $client->request('GET', '/api/clients');
        
        // Si on demande si la réponse est réussie -> Erreur : "Failed asserting that the Response is successful. Code 401 Unauthorized. JWT Token not found"
        // $this->assertResponseIsSuccessful();

        // On ne peut pas accéder aux endpoints sans l'autorisation Bearer JWT Token
        // HTTP Error 401 -> Unauthorized
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/api/products');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/api/consumers');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());

    }


}
