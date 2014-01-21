<?php

namespace Core\Util\Mail;

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class MandrillAdapterTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Core\Util\Mail\Exception
	 */
	public function testInvalidAPIKeyException() {
		MailFactory::setDriver(new MandrillAdapter('1234'));

		MailFactory::getDriver()->send();
	}

}
