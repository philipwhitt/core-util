<?php

namespace Core\Util\Mail;

class MailFactory {

	private static $driver;

	public static function setDriver(Driver $mailDriver) {
		self::$driver = $mailDriver;
	}

	public static function getDriver() {
		if (!isset(self::$driver)) {
			throw new Exception('Mail driver not set');
		}
		return self::$driver;
	}

}