<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorTrait;

class LocaleTest extends WebTestCase
{ 
	protected $translator;

	public function setUp(){

		$kernel = static::createKernel();
		$kernel->boot();
		$this->translator = $kernel->getContainer()->get('translator');

	}

	public function tearDown(){
		$this->translator = null;
	}

	public function testIndex(){

		$this->translator->setLocale('en_US');
		$this->assertEquals('en_US', $this->translator->getLocale());

		$this->assertEquals('AddressBook', $this->translator->trans('nav.main'));

		$this->translator->setLocale('de_DE');
		$this->assertEquals('de_DE', $this->translator->getLocale());

		$this->assertEquals('Adressbuch', $this->translator->trans('nav.main'));
		
	}
}