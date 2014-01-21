<?php

namespace Core\Util\Mail;

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class MailAdapterTest extends \PHPUnit_Framework_TestCase {

	public function setup() {
		MailFactory::setDriver(new MailAdapter());
	}

	public function teardown() {
		MailFactory::reset();
	}

	public function testDriver() {
		$driver = MailFactory::getDriver();

		$driver->setTo('P Whitt', 'pwhit@'.uniqid().'.com');
		$driver->setFrom('Unit Test', 'test@'.uniqid().'.com');
		$driver->setBody('This is a test');

		$driver->send();

		$this->assertTrue(true);
	}

}
