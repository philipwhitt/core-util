<?php

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

use Core\Util\Db as db;

/**
 * relies on a database named "test" being created with a user called "localhost" having access to it
 */
class FactoryTest extends PHPUnit_Framework_TestCase {

	private $refDriver;

	public function setup() {
		$this->refDriver = new db\Decorator(new db\MysqlDriver('127.0.0.1', 'localhost', '', 'test'));
		$this->refDriver->connect();

		$this->refDriver->query('DROP TABLE IF EXISTS test;');
		$this->refDriver->query('CREATE TABLE test(`id` int(1) NOT NULL, `name` varchar(255) NOT NULL) ENGINE=MyISAM  DEFAULT CHARSET=latin1;');
	}

	public function tearDown() {
		$this->refDriver->query('DROP TABLE IF EXISTS test;');
	}

	public function testSelectAll() {
		$this->refDriver->insert('INSERT INTO test(`id`) VALUES (1), (2), (3), (4);');

		$records = $this->refDriver->select('SELECT * FROM test;');

		$this->assertEquals($records->count(), 4);
	}

	public function testSelect() {
		$this->refDriver->insert('INSERT INTO test(`id`) VALUES (1), (2);');

		$rs = $this->refDriver->selectRecord('SELECT * FROM test WHERE id=?;', array(1));

		$this->assertEquals($rs->id, 1);
	}

	public function testDelete() {
		$this->refDriver->insert('INSERT INTO test(`id`) VALUES (1), (2);');

		$this->refDriver->delete('DELETE FROM test WHERE id=?', array(2));

		$records = $this->refDriver->select('SELECT * FROM test;');

		$this->assertEquals($records->count(), 1);
	}

	public function testInsertMany() {
		$this->refDriver->insertMany('INSERT INTO test(`id`) VALUES (?)', array(
			array(1), 
			array(2), 
			array(3), 
			array(4)
		));

		$records = $this->refDriver->select('SELECT * FROM test;');

		$this->assertEquals($records->count(), 4);
	}

	public function testUpdate() {
		$this->refDriver->insert('INSERT INTO test(`id`, `name`) VALUES (1, \'hello\'), (2, \'world\');');

		$this->refDriver->update('UPDATE test SET `name`=? WHERE id=?', array('hi', 1));

		$rs = $this->refDriver->selectRecord('SELECT * FROM test WHERE id=?;', array(1));

		$this->assertEquals($rs->name, 'hi');
	}

}
