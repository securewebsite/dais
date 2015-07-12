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
		$this->db->query("
			INSERT INTO {$this->db->prefix}email 
			SET 
				email_slug         = '" . $this->db->escape($data['email_slug']) . "', 
				configurable       = '" . (int)$data['configurable'] . "', 
				priority           = '" . (int)$data['priority'] . "', 
				config_description = '" . $this->db->escape($data['config_description']) . "', 
				recipient          = '" . (int)$data['recipient'] . "', 
				is_system          = '" . (int)$data['is_system'] . "'
		");

		$id = $this->db->getLastId();

		foreach ($data['email_content'] as $language_id => $value):
			$this->db->query("
				INSERT INTO {$this->db->prefix}email_content 
				SET 
					email_id    = '" . (int)$id . "', 
					language_id = '" . (int)$language_id . "', 
					subject     = '" . $this->db->escape($value['subject']) . "', 
					text        = '" . $this->db->escape($value['text']) . "',
					html        = '" . $this->db->escape($value['html']) . "'
			");
		endforeach;

		Theme::trigger('admin_add_notification', array('notification_id' => $id));
	}

	public function editNotification($id, $data) {
		$this->db->query("
			UPDATE {$this->db->prefix}email 
			SET 
				email_slug         = '" . $this->db->escape($data['email_slug']) . "', 
				configurable       = '" . (int)$data['configurable'] . "', 
				priority           = '" . (int)$data['priority'] . "', 
				config_description = '" . $this->db->escape($data['config_description']) . "', 
				recipient          = '" . (int)$data['recipient'] . "', 
				is_system          = '" . (int)$data['is_system'] . "' 
			WHERE email_id = '" . (int)$id . "'
		");
        
        $this->db->query("
        	DELETE FROM {$this->db->prefix}email_content 
        	WHERE email_id = '" . (int)$id . "'");
        
        foreach ($data['email_content'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}email_content 
				SET 
					email_id    = '" . (int)$id . "', 
					language_id = '" . (int)$language_id . "', 
					subject     = '" . $this->db->escape($value['subject']) . "', 
					text        = '" . $this->db->escape($value['text']) . "', 
					html        = '" . $this->db->escape($value['html']) . "'
			");
        }

        Theme::trigger('admin_edit_notification', array('notification_id' => $id));
	}

	public function deleteNotification($id) {
		$this->db->query("
			DELETE FROM {$this->db->prefix}email 
			WHERE email_id = '" . (int)$id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}email_content 
        	WHERE email_id = '" . (int)$id . "'");

        Theme::trigger('admin_delete_notification', array('notification_id' => $id));
	}

	public function getTotalNotifications() {
		$query = $this->db->query("
			SELECT COUNT(email_id) AS total 
			FROM {$this->db->prefix}email");

		return $query->row['total'];
	}

	public function getNotifications($data = array()) {
		$sql = "
			SELECT * 
			FROM {$this->db->prefix}email e 
			LEFT JOIN {$this->db->prefix}email_content ec 
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

        $query = $this->db->query($sql);

        return $query->rows;
	}

	public function getNotification($id) {
		$query = $this->db->query("
			SELECT DISTINCT * 
			FROM {$this->db->prefix}email 
			WHERE email_id = '" . (int)$id . "'
		");
        
        return $query->row;
	}

	public function getNotificationContent($id) {
        $data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}email_content 
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
    	$query = $this->db->query("
    		SELECT is_system 
    		FROM {$this->db->prefix}email 
    		WHERE email_id = '" . (int)$id ."'");

    	return $query->row['is_system'];
    }
}
