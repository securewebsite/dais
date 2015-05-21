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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Email extends LibraryService {

	public function __construct(Container $app) {
		parent::__construct($app);
	}

	public function fetchWrapper($priority) {
        $db = parent::$app['db'];

        $data = array();

        $query = $db->query("
            SELECT 
                ec.text AS text, 
                ec.html AS html 
            FROM {$db->prefix}email_content ec 
            LEFT JOIN {$db->prefix}email e 
            ON (e.email_id = ec.email_id) 
            WHERE e.email_slug = 'email_wrapper' 
            AND priority = '" . (int)$priority . "' 
            AND language_id = '" . (int)parent::$app['config_language_id'] . "'
        ");

        $data['text'] = $query->row['text'];
        $data['html'] = $query->row['html'];

        return $data;
    }

	public function fetch($name) {
		$data = array();

		$db = parent::$app['db'];

		$query = $db->query("
			SELECT 
				ec.subject AS subject, 
				ec.text AS text, 
				ec.html AS html, 
				e.priority AS priority 
			FROM {$db->prefix}email_content ec 
			LEFT JOIN {$db->prefix}email e 
			ON (e.email_id = ec.email_id) 
			WHERE e.email_slug = '" . $db->escape($name) . "' 
			AND language_id = '" . (int)parent::$app['config_language_id'] . "'
		");

		$data['subject']  = html_entity_decode($query->row['subject'], ENT_QUOTES, 'UTF-8');
		$data['text']     = html_entity_decode($query->row['text'], ENT_QUOTES, 'UTF-8');
		$data['html']     = html_entity_decode($query->row['html'], ENT_QUOTES, 'UTF-8');
		$data['priority'] = $query->row['priority'];

		return $data;
	}

	public function addToEmailQueue($message, $email, $name) {
		$db = parent::$app['db'];

		$db->query("
			INSERT INTO {$db->prefix}notification_queue 
			SET 
				email      = '" . $db->escape($email) . "', 
				name       = '" . $db->escape($name) . "', 
				subject    = '" . $db->escape($message['subject']) . "', 
				date_added = NOW()
		");

		return $db->getLastId();
    }

    public function updateHtml($id, $message) {
    	$db = parent::$app['db'];

    	$db->query("
    		UPDATE {$db->prefix}notification_queue 
			SET 
				text = '" . $db->escape($message['text']) . "', 
				html = '" . $db->escape($message['html']) . "' 
			WHERE queue_id = '" . (int)$id . "'
    	");
    }

    public function send($message, $to, $name, $send = false, $add = array()) {
        
        parent::$app['mailer']->build(
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
