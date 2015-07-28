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
*/

namespace App\Controllers\Front\Common;

use App\Controllers\Controller;

class Queue extends Controller {
	
	private $queued;

	public function index() {
		// /usr/bin/curl -s -L "http://dev.dais.io/queue" > /dev/null
		Theme::model('tool/utility');

		// First let's delete all sent emails to ease the search query
		// this -> model_tool_utility -> pruneQueue // future use

		// Now we can just grab the first 50
		$emails = ToolUtility::getQueue();

		if ($emails):
			foreach($emails as $email):
				$this->queued[] = $email;
			endforeach;
		endif;

		$this->process();
	}

	private function process() {
		if ($this->queued):
			foreach ($this->queued as $email):
				Mailer::build($email['subject'], $email['email'], $email['name'], $email['text'], $email['html'], true);
				// comment previous and uncomment below to test text message
				//Mailer::build($email['subject'], $email['email'], $email['name'], $email['text'], false, true);
				ToolUtility::updateQueue($email['queue_id']);
			endforeach;
		endif;
	}
}
