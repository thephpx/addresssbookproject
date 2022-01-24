<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteAddressTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Confrim Address Deletion', $crawler->filter('.container-fluid h3')->text());
    }
}
