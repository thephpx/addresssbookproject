<?php

namespace Tests\AppBundle\Form;

use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

use AppBundle\Form\AddressType;
use AppBundle\Entity\Address;

class AddressTest extends TypeTestCase
{

    protected function getExtensions()
    {
        return [new ValidatorExtension(Validation::createValidator())];
    }

    public function testIndex()
    {
        $formData = [
            'firstname'=>'faisal',
            'lastname'=>'ahmed',
            'email'=>'faisbd@gmail.com',
            'phonenumber'=>'12345678',
            'dob'=> '1985-12-12',
            'street_address'=>'123 Street',
            'city'=>'Dhaka',
            'zip'=>'1230',
            'country'=>'BD',
            'picture'=>'',
        ];

        $model = new Address();

        $form = $this->factory->create(AddressType::class, $model);

        $expected = new Address();
        $expected->setFirstname($formData['firstname']);
        $expected->setLastname($formData['lastname']);
        $expected->setEmail($formData['email']);
        $expected->setPhonenumber($formData['phonenumber']);
        $expected->setDob(new \DateTime($formData['dob']));
        $expected->setStreetAddress($formData['street_address']);
        $expected->setCity($formData['city']);
        $expected->setCountry($formData['country']);
        $expected->setZip($formData['zip']);
        $expected->setPicture(null);//empty value sets to null

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }
}
