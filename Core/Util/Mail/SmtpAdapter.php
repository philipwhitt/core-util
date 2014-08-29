<?php

namespace Core\Util\Mail;

class SmtpAdapter implements Driver {

	private $host;
	private $user;
	private $pass;
	private $smtpAuth;
	private $smtpSecure;
	private $smtpPort;

	private $to;
	private $fromName;
	private $from;
	private $subject;
	private $body;

	public function __construct($host, $user, $pass, $smtpAuth=false, $smtpSecure=null, $smtpPort=null) {
		$this->host       = $host;
		$this->user       = $user;
		$this->pass       = $pass;
		$this->smtpAuth   = $smtpAuth;
		$this->smtpSecure = $smtpSecure;
		$this->smtpPort   = $smtpPort;
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
		
		$mail->SMTPAuth   = $this->smtpAuth;

		if (!is_null($this->smtpSecure)) {
			$mail->SMTPSecure = $this->smtpSecure;
		}

		if (!is_null($this->smtpPort)) {
			$mail->Port = $this->smtpPort;
		}

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