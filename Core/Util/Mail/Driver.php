<?php

namespace Core\Util\Mail;

interface Driver {

	public function setTo($name, $address);
	public function setFrom($name, $address);
	public function setSubject($subject);
	public function setBody($body);
	public function send();

}