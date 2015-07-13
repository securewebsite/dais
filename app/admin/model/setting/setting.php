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

namespace Admin\Model\Setting;
use Dais\Base\Model;

class Setting extends Model {
    public function getSetting($group, $store_id = 0) {
        $data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}setting 
			WHERE store_id = '" . (int)$store_id . "' 
			AND section = '" . $this->db->escape($group) . "'
		");
        
        foreach ($query->rows as $result) {
            if (!$result['serialized']) {
                $data[$result['item']] = $result['data'];
            } else {
                $data[$result['item']] = unserialize($result['data']);
            }
        }
        
        return $data;
    }
    
    public function editSetting($group, $data, $store_id = 0) {
        $this->deleteSetting($group, $store_id);
        
        foreach ($data as $key => $value):
            if (!is_array($value)):
                $this->db->query("
					INSERT INTO {$this->db->prefix}setting 
					SET 
						store_id = '" . (int)$store_id . "', 
						section = '" . $this->db->escape($group) . "', 
						item = '" . $this->db->escape($key) . "', 
						data = '" . $this->db->escape($value) . "'
				");
            else:
                $this->db->query("
					INSERT INTO {$this->db->prefix}setting 
					SET 
						store_id = '" . (int)$store_id . "', 
						section = '" . $this->db->escape($group) . "', 
						item = '" . $this->db->escape($key) . "', 
						data = '" . $this->db->escape(serialize($value)) . "', 
						serialized = '1'
				");
            endif;
        endforeach;
        
        $this->cache->delete('default');
    }
    
    public function deleteSetting($group, $store_id = 0) {
        $this->db->query("
			DELETE FROM {$this->db->prefix}setting 
			WHERE store_id = '" . (int)$store_id . "' 
			AND section = '" . $this->db->escape($group) . "'
		");
        
        $this->cache->delete('default');
    }
    
    public function getSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
        $query = $this->db->query("
			SELECT data 
			FROM {$this->db->prefix}setting 
			WHERE section = '" . $this->db->escape($group) . "' 
			AND item = '" . $this->db->escape($key) . "' 
			AND store_id = '" . (int)$store_id . "'");
        
        if ($query->num_rows):
            return true;
        else:
            return false;
        endif;
    }
    
    public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
        if (!is_array($value)) {
            $this->db->query("
				UPDATE {$this->db->prefix}setting 
				SET 
					data = '" . $this->db->escape($value) . "' 
				WHERE section = '" . $this->db->escape($group) . "' 
				AND item = '" . $this->db->escape($key) . "' 
				AND store_id = '" . (int)$store_id . "'
			");
        } else {
            $this->db->query("
				UPDATE {$this->db->prefix}setting 
				SET 
					data = '" . $this->db->escape(serialize($value)) . "' 
				WHERE section = '" . $this->db->escape($group) . "' 
				AND item = '" . $this->db->escape($key) . "' 
				AND store_id = '" . (int)$store_id . "', 
				serialized = '1'
			");
        }
        
        $this->cache->delete('default');
    }
}
