<?php

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

use Core\Util\Mail as mail;

class FactoryTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Core\Util\Mail\Exception
	 */
	public function testDriverNotSet() {
		mail\MailFactory::getDriver();
	}

}
