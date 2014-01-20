<?php

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

use Core\Util\Mail as mail;

class MailAdapterTest extends PHPUnit_Framework_TestCase {

	public function setup() {
		mail\MailFactory::setDriver(new mail\MailAdapter());
	}

	public function teardown() {
		mail\MailFactory::reset();
	}

	public function testDriver() {
		$driver = mail\MailFactory::getDriver();

		$driver->setTo('P Whitt', 'pwhit@'.uniqid().'.com');
		$driver->setFrom('Unit Test', 'test@'.uniqid().'.com');
		$driver->setBody('This is a test');

		$driver->send();

		$this->assertTrue(true);
	}

}
