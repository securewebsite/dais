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

namespace Dais\Services\Providers;

class Email {

	public function fetchWrapper($priority) {
        $data = array();

        $query = \DB::query("
            SELECT 
                ec.text AS text, 
                ec.html AS html 
            FROM ". \DB::p()->prefix . "email_content ec 
            LEFT JOIN ". \DB::p()->prefix . "email e 
            ON (e.email_id = ec.email_id) 
            WHERE e.email_slug = 'email_wrapper' 
            AND priority = '" . (int)$priority . "' 
            AND language_id = '" . (int)\Config::get('config_language_id') . "'
        ");

        $data['text'] = $query->row['text'];
        $data['html'] = $query->row['html'];

        return $data;
    }

	public function fetch($name) {
		$data = array();

		$query = \DB::query("
			SELECT 
				ec.subject AS subject, 
				ec.text AS text, 
				ec.html AS html, 
				e.priority AS priority 
			FROM ". \DB::p()->prefix . "email_content ec 
			LEFT JOIN ". \DB::p()->prefix . "email e 
			ON (e.email_id = ec.email_id) 
			WHERE e.email_slug = '" . \DB::escape($name) . "' 
			AND language_id = '" . (int)\Config::get('config_language_id') . "'
		");

		$data['subject']  = html_entity_decode($query->row['subject'], ENT_QUOTES, 'UTF-8');
		$data['text']     = html_entity_decode($query->row['text'], ENT_QUOTES, 'UTF-8');
		$data['html']     = html_entity_decode($query->row['html'], ENT_QUOTES, 'UTF-8');
		$data['priority'] = $query->row['priority'];

		return $data;
	}

	public function addToEmailQueue($message, $email, $name) {
		\DB::query("
			INSERT INTO ". \DB::p()->prefix . "notification_queue 
			SET 
				email      = '" . \DB::escape($email) . "', 
				name       = '" . \DB::escape($name) . "', 
				subject    = '" . \DB::escape($message['subject']) . "', 
				date_added = NOW()
		");

		return \DB::getLastId();
    }

    public function updateHtml($id, $message) {
    	\DB::query("
    		UPDATE ". \DB::p()->prefix . "notification_queue 
			SET 
				text = '" . \DB::escape($message['text']) . "', 
				html = '" . \DB::escape($message['html']) . "' 
			WHERE queue_id = '" . (int)$id . "'
    	");
    }

    public function send($message, $to, $name, $send = false, $add = array()) {
        
        \Mailer::build(
            $message['subject'],
            $to,
            $name,
            $message['text'],
            $message['html'],
            $send,
            $add
        );
    }
}
