<?php

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

use Core\Util\Config as config;

class ConfigMapperTest extends PHPUnit_Framework_TestCase {

	public function testGetter() {
		$config = new config\Mapper(array(
			"env" => array(
				"debug" => true,
				"db"    => array(
					"host" => "localhost",
					"user" => "philip",
					"pass" => "1234",
				),
			),
		));

		$this->assertEquals($config->env->db->host, 'localhost');
	}

	/**
	 * @expectedException Core\Util\Config\Exception
	 */
	public function testGetError() {
		$config = new config\Mapper(array(
			"env" => array(
				"debug" => true
			),
		));

		$config->env->db;
	}

	/**
	 * @expectedException Core\Util\Config\Exception
	 */
	public function testSetError() {
		$config = new config\Mapper(array(
			"env" => array(
				"debug" => true
			),
		));

		$config->env = array("test" => "Test");
	}

}
