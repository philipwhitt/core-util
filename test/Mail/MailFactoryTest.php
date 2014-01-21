<?php

namespace Core\Util\Mail;

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class FactoryTest extends \PHPUnit_Framework_TestCase {

	public function teardown() {
		MailFactory::reset();
	}

	/**
	 * @expectedException Core\Util\Mail\Exception
	 */
	public function testDriverNotSet() {
		MailFactory::getDriver();
	}

	public function testStubDriver() {
		MailFactory::setDriver(new StubAdapter());

		MailFactory::getDriver()->send();
		MailFactory::getDriver()->send();

		$this->assertEquals(MailFactory::getDriver()->sends, 2);
	}

}
