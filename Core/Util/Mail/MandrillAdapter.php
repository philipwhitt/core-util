<?php

namespace Core\Util\Mail;

class MandrillAdapter implements Driver {

	private $apiKey;
	private $tags;
	private $template;
	private $templateContent;

	private $to;
	private $fromName;
	private $from;
	private $subject;
	private $body;

	public function __construct($apiKey, array $tags=array(), $template=null, $templateContent=null) {
		$this->apiKey          = $apiKey;
		$this->tags            = $tags;
		$this->template        = $template;
		$this->templateContent = $templateContent;
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
		try {
			$mandrill = new \Mandrill($this->apiKey);

			$message = array(
				'text'       => $this->body,
				'subject'    => $this->subject,
				'from_email' => $this->from,
				'from_name'  => $this->fromName,
				'to'         => array(array('email' => $this->to)),
				'tags'       => $this->tags,
			);

			$async   = true;
			$ip_pool = 'Main Pool';
			$send_at = date('Y-m-d g:i:s', time());

			if (!is_null($this->template)) {
				$mandrill->messages->sendTemplate($this->template, $this->templateContent, $message, $async, $ip_pool, $send_at);

			} else {
				$mandrill->messages->send($message, $async, $ip_pool, $send_at);
			}

		} catch(\Mandrill_Error $e) {
			throw new Exception($e->getMessage());
		}

	}

}