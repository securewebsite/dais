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

namespace App\Models\Admin\Module;

use App\Models\Model;

class Notification extends Model {
	
	public function addNotification($data) {
		DB::query("
			INSERT INTO " . DB::prefix() . "email 
			SET 
				email_slug         = '" . DB::escape($data['email_slug']) . "', 
				configurable       = '" . (int)$data['configurable'] . "', 
				priority           = '" . (int)$data['priority'] . "', 
				config_description = '" . DB::escape($data['config_description']) . "', 
				recipient          = '" . (int)$data['recipient'] . "', 
				is_system          = '" . (int)$data['is_system'] . "'
		");

		$id = DB::getLastId();

		foreach ($data['email_content'] as $language_id => $value):
			DB::query("
				INSERT INTO " . DB::prefix() . "email_content 
				SET 
					email_id    = '" . (int)$id . "', 
					language_id = '" . (int)$language_id . "', 
					subject     = '" . DB::escape($value['subject']) . "', 
					text        = '" . DB::escape($value['text']) . "',
					html        = '" . DB::escape($value['html']) . "'
			");
		endforeach;

		Theme::trigger('admin_add_notification', array('notification_id' => $id));
	}

	public function editNotification($id, $data) {
		DB::query("
			UPDATE " . DB::prefix() . "email 
			SET 
				email_slug         = '" . DB::escape($data['email_slug']) . "', 
				configurable       = '" . (int)$data['configurable'] . "', 
				priority           = '" . (int)$data['priority'] . "', 
				config_description = '" . DB::escape($data['config_description']) . "', 
				recipient          = '" . (int)$data['recipient'] . "', 
				is_system          = '" . (int)$data['is_system'] . "' 
			WHERE email_id = '" . (int)$id . "'
		");
        
        DB::query("
        	DELETE FROM " . DB::prefix() . "email_content 
        	WHERE email_id = '" . (int)$id . "'");
        
        foreach ($data['email_content'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "email_content 
				SET 
					email_id    = '" . (int)$id . "', 
					language_id = '" . (int)$language_id . "', 
					subject     = '" . DB::escape($value['subject']) . "', 
					text        = '" . DB::escape($value['text']) . "', 
					html        = '" . DB::escape($value['html']) . "'
			");
        }

        Theme::trigger('admin_edit_notification', array('notification_id' => $id));
	}

	public function deleteNotification($id) {
		DB::query("
			DELETE FROM " . DB::prefix() . "email 
			WHERE email_id = '" . (int)$id . "'");

        DB::query("
        	DELETE FROM " . DB::prefix() . "email_content 
        	WHERE email_id = '" . (int)$id . "'");

        Theme::trigger('admin_delete_notification', array('notification_id' => $id));
	}

	public function getTotalNotifications() {
		$query = DB::query("
			SELECT COUNT(email_id) AS total 
			FROM " . DB::prefix() . "email");

		return $query->row['total'];
	}

	public function getNotifications($data = array()) {
		$sql = "
			SELECT * 
			FROM " . DB::prefix() . "email e 
			LEFT JOIN " . DB::prefix() . "email_content ec 
			ON (e.email_id = ec.email_id) 
			WHERE ec.language_id = '" . (int)Config::get('config_language_id') . "'";

		if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = Config::get('config_admin_limit');
            endif;
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;

        $query = DB::query($sql);

        return $query->rows;
	}

	public function getNotification($id) {
		$query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "email 
			WHERE email_id = '" . (int)$id . "'
		");
        
        return $query->row;
	}

	public function getNotificationContent($id) {
        $data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "email_content 
			WHERE email_id = '" . (int)$id . "'
		");
        
        foreach ($query->rows as $result):
            $data[$result['language_id']] = array(
				'subject' => $result['subject'],
				'text'    => $result['text'], 
				'html'    => $result['html']
            );
        endforeach;
        
        return $data;
    }

    public function checkSystem($id) {
    	$query = DB::query("
    		SELECT is_system 
    		FROM " . DB::prefix() . "email 
    		WHERE email_id = '" . (int)$id ."'");

    	return $query->row['is_system'];
    }
}
