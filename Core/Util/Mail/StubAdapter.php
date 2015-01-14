<?php

namespace Core\Util\Mail;

class StubAdapter implements Driver {

	public $sends = 0;

	public $to;
	public $fromName;
	public $from;
	public $subject;
	public $body;

	public function setTo($name, $address) {
		$this->to = $address;
	}
	public function setFrom($name, $address) {
		$this->fromName = $name;
		$this->from     = $address;
	}
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	public function setBody($body) {
		$this->body = $body;
	}
	public function setTags(array $tags) {}
	public function setTemplate($template) {}
	public function setTemplateContent($templateContent) {}

	public function send() {
		$this->sends++;
	}

}
