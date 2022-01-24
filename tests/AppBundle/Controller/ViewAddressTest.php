<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ViewAddressTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/view/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Address Details', $crawler->filter('.container-fluid h3')->text());
    }
}
