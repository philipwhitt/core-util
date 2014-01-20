<?php

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

use Core\Util\Mail as mail;

class MandrillAdapterTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Core\Util\Mail\Exception
	 */
	public function testInvalidAPIKeyException() {
		mail\MailFactory::setDriver(new mail\MandrillAdapter('1234'));

		mail\MailFactory::getDriver()->send();
	}

}
