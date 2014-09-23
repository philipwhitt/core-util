<?php

namespace Core\Util\Db;

class Registry {

	private static $instance;

	private $map = array();
	private $cache = array();

	public static function get() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function register($key, $package) {
		if (isset(self::get()->map[$key])) {
			throw new Exception("$key already exists.");
		}

		self::get()->map[$key] = $package;
	}

	public function dataMapper($key) {
		if (!isset($this->map[$key])) {
			throw new Exception("Unknown mapper $key");
		}

		if (!isset($this->cache[$key])) {
			$class = $this->map[$key].'\DataMapper';
			$this->cache[$key] = new $class;
		}

		return $this->cache[$key];
	}

	public static function reset() {
		self::$instance = null;
	}

}