<?php

namespace Core\Util\Config;

class Mapper {

	private static $config;

	private $params;

	public function __construct(array $configParams) {
		$this->params = $configParams;
	}

	public function __get($name) {
		if (!isset($this->params[$name])) {
			throw new Exception($name.' not found');
		}
		
		if (is_array($this->params[$name])) {
			return new self($this->params[$name]);
		}
		return $this->params[$name];
	}

	public function __set($name, $value) {
		throw new Exception('Config is read only');
	}

	public static function set(Mapper $mapper) {
		self::$config = $mapper;
	}

	public static function get() {
		if (!isset(self::$config)) {
			throw new Exception('Config not set');
		}
		return self::$config;
	}

}