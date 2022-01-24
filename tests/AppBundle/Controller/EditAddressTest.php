<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditAddressTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Update Address', $crawler->filter('.container-fluid h3')->text());
    }
}
