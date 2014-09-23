<?php

namespace Core\Util\Model;

require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

class ObjectMapperTest extends \PHPUnit_Framework_TestCase {

	private $refModel;

	public function setup() {
		$this->refModel = new TestModel();
		$this->refModel->fname = "Bob";
		$this->refModel->setName("hello");
		$this->refModel->setLname("loblaw");
	}

	public function testEncode() {
		$obj = clone $this->refModel;

		$mpr = new ObjectMapper();
		$enc = $mpr->getEncoded($obj);

		$this->assertEquals($enc, array(
			"fname" => "Bob",
			"lname" => "loblaw",
			"name"  => "hello",
		));
	}

	public function testDecode() {
		$obj = clone $this->refModel;

		$mpr = new ObjectMapper();
		$obj2 = $mpr->getFromEncoded($mpr->getEncoded($obj), new TestModel());

		$this->assertEquals($obj, $obj2);
	}

	public function testEncodeDecodeAll() {
		$obj = clone $this->refModel;

		$mpr = new ObjectMapper();
		$objs = $mpr->getAllFromEncoded($mpr->getAllEncoded(array($obj)), new TestModel());

		$this->assertEquals(array($obj), $objs);
	}

	public function testJsonEncode() {
		$obj = clone $this->refModel;

		$mpr = new ObjectMapper();
		$json = $mpr->getJsonEncoded($obj);

		$this->assertEquals($json, '{"fname":"Bob","lname":"loblaw","name":"hello"}');
	}

	public function testJsonDecode() {
		$obj = clone $this->refModel;

		$mpr = new ObjectMapper();
		$obj2 = $mpr->getFromJsonEncoded($mpr->getJsonEncoded($obj), new TestModel());

		$this->assertEquals($obj, $obj2);
	}

}

class TestModel {
	
	public $fname;
	protected $lname;
	private $name;

	public function setName($value) {
		$this->name = $value;
	}

	public function setLname($value) {
		$this->lname = $value;
	}
}