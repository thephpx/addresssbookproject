<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use AppBundle\Form\AddressType;
use AppBundle\Entity\Address;
use AppBundle\Repository\AddressRepository;

class CreateAddressTest extends WebTestCase
{
    private $client;
    private $container;
    private $em;

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
        $this->em = null;
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Create New Address', $crawler->filter('.container-fluid h3')->text());
    }

    public function testCreatePost()
    {
        $formData = [
            'firstname'=>'faisal'.rand(),
            'lastname'=>'ahmed',
            'email'=>'faisbd2@gmail.com',
            'phonenumber'=>'12345678',
            'dob'=> '1985-12-12',
            'street_address'=>'123 Street',
            'city'=>'Dhaka',
            'zip'=>'1230',
            'country'=>'BD',
            'picture'=>'',
        ];

        $address = new Address();
        $address->setFirstname($formData['firstname']);
        $address->setLastname($formData['lastname']);
        $address->setEmail($formData['email']);
        $address->setPhonenumber($formData['phonenumber']);
        $address->setDob(new \DateTime($formData['dob']));
        $address->setStreetAddress($formData['street_address']);
        $address->setCity($formData['city']);
        $address->setCountry($formData['country']);
        $address->setZip($formData['zip']);
        $address->setPicture($formData['picture']);

        $this->em->persist($address);
        $this->em->flush();

        $row = $this->em->getRepository(Address::class)->findOneBy(['firstname'=>$formData['firstname']]);

        $this->assertEquals($address->getFirstname(), $row->getFirstname());
        $this->assertEquals($address->getLastname(), $row->getLastname());
    }

    public function testUpdatePost()
    {        
        $row1 = $this->em->getRepository(Address::class)->findOneBy(['email'=>'faisbd2@gmail.com']);

        $row1->setEmail('faisbd@gmail.com');

        $this->em->persist($row1);
        $this->em->flush();

        $row2 = $this->em->getRepository(Address::class)->findOneBy(['email'=>'faisbd@gmail.com']);

        $this->assertEquals($row1, $row2);
    }

    public function testRemovePost()
    {        
        $row1 = $this->em->getRepository(Address::class)->findOneBy(['email'=>'faisbd@gmail.com']);

        $this->em->remove($row1);
        $this->em->flush();

        $row2 = $this->em->getRepository(Address::class)->findOneBy(['email'=>'faisbd@gmail.com']);

        $this->assertNull($row2);
    }
}
