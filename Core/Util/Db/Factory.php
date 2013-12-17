<?php

namespace Core\Util\Db;

class Factory {

	private static $driver;

	public static function setDriver(Driver $driver) {
		self::$driver = $driver;
	}

	public static function getDriver() {
		if (!isset(self::$driver)) {
			throw new DriverNotSetException();
		}

		$driver = self::$driver;

		if (!$driver->hasConnection()) {
			$driver->connect();
		}

		return new Decorator($driver);
	}

}