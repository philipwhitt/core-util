<?php

namespace Core\Util\Db;

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class RegistryTest extends \PHPUnit_Framework_TestCase {

	public function teardown() {
		Registry::reset();
		DataMapper::$built=0;
	}

	public function testGetSet() {
		Registry::register("StubMapper", "Core\Util\Db");
		
		$this->assertTrue(Registry::get()->dataMapper("StubMapper") instanceof DataMapper);
	}

	public function testCache() {
		Registry::register("StubMapper", "Core\Util\Db");

		Registry::get()->dataMapper("StubMapper");
		Registry::get()->dataMapper("StubMapper");
		Registry::get()->dataMapper("StubMapper");
	
		$this->assertEquals(DataMapper::$built, 1);
	}

}

class DataMapper {

	public static $built = 0;

	public function __construct() {
		self::$built++;
	}

}
