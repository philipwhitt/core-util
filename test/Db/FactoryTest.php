<?php

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

use Core\Util\Db as db;

class FactoryTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Core\Util\Db\DriverNotSetException
	 */
	public function testDriverNotSet() {
		db\Factory::getDriver();
	}

	public function testGetDriver() {
		$driver = new db\MysqlDriver('127.0.0.1', '', '', 'test');
		db\Factory::setDriver($driver);

		$this->assertEquals(db\Factory::getDriver(), new db\Decorator($driver));
	}

}
