<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
|--------------------------------------------------------------------------
|   Swiftmailer Wrapper
|--------------------------------------------------------------------------
|
|   This class is a simple PHP wrapper for Swiftmailer.
*/

namespace Dais\Services\Providers\Communication;

use Swift_Mailer;
use Swift_Message;
use Swift_MailTransport;
use Swift_SmtpTransport;
use Swift_Plugins_LoggerPlugin;
use Swift_Plugins_Loggers_EchoLogger;

class Mail {

	private $mailer;
	private $message;
	private $logger;
	private $debug = false;

	public function __construct() {
		
		/**
		 * Our application will build a new instance
		 * of this mailer in the baseClasses() method
		 * then all pieces of an email can be passed
		 * to the build method, and sent immediately.
		 */
		
		if (Config::get('config_mail_protocol') === 'mail'):
			$transport = Swift_MailTransport::newInstance();
		else:
			$transport = Swift_SmtpTransport::newInstance(Config::get('config_smtp_host'), Config::get('config_smtp_port'))
				->setUsername(Config::get('config_smtp_username'))
				->setPassword(Config::get('config_smtp_password'));
		endif;

		$this->mailer = Swift_Mailer::newInstance($transport);

		if ($this->debug):
			$this->logger = new Swift_Plugins_Loggers_EchoLogger();
			$this->mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($this->logger));
		endif;
	}

	public function build($subject, $email, $name, $text, $html = false, $send = false, $add = array()) {
		$message = Swift_Message::newInstance()
			->setFrom(array(Config::get('config_email') => Config::get('config_name')));

		// customer/function specific details
		$message->setSubject($subject);
		$message->setTo(array($email => $name));

		$message->setBody($text, 'text/plain');
		
		if ($html):
			$message->addPart($html, 'text/html');
		endif;
		
		if (!empty($add)):
			$message->setCc($add);
		endif;

		$this->message = $message;

		if ($send) $this->send();
	}

	/**
	 * used to override the defaults for sending message to
	 * admins on contact, order, register etc.
	 * @param string $email [from email address]
	 * @param string $name  [from name]
	 */
	public function setFrom($email, $name) {
		$this->message->setFrom(array($email => $name));
	}

	public function send() {
		$this->mailer->send($this->message);
		unset($this->message);
	}
}
