<?php

namespace Core\Util\Mail;

class SmtpAdapter implements Driver {

	private $host;
	private $user;
	private $pass;

	private $to;
	private $fromName;
	private $from;
	private $subject;
	private $body;

	public function __construct($host, $user, $pass) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
	}

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

	public function send() {
		$mail = new \PHPMailer();
		$mail->isSMTP();
		$mail->Host     = $this->host;
		$mail->Username = $this->user;
		$mail->Password = $this->pass;

		$mail->Subject  = $this->subject;
		$mail->Body     = $this->body;

		$mail->From     = $this->from;
		$mail->FromName = $this->fromName;

		$mail->addReplyTo($this->from, $this->fromName);

		$mail->addAddress($this->to, ''); 

		if (!$mail->send()) {
			throw new Exception($mail->ErrorInfo);
		}
	}

}