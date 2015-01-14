<?php

namespace Core\Util\Mail;

class MailAdapter implements Driver {

	private $to;
	private $fromName;
	private $from;
	private $subject;
	private $body;

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
		$headers = 'From: ' .$this->from. "\r\n" . 
			'X-Mailer: Core.Util.Mail';

		mail($this->to, $this->subject, $this->body, $headers);
	}

}