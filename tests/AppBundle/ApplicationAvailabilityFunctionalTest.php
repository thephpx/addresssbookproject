<?php
namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use AppBundle\Entity\Address;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
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

        // Filling up in-memory database with dummy data to ensure edit/view/delete pages dont throw 404
        $formData = [
            'firstname'=>'faisal',
            'lastname'=>'ahmed',
            'email'=>'thephpx@gmail.com',
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
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return [
            ['/'],
            ['/create'],
            ['/edit/1'],
            ['/delete/1'],
            ['/view/1'],
        ];
    }

}