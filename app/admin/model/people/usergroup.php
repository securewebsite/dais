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

namespace Admin\Model\People;
use Dais\Engine\Model;

class Usergroup extends Model {
    public function addUserGroup($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}user_group 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				permission = '" . (isset($data['permission']) ? serialize($data['permission']) : '') . "'
		");
        
        $this->user->reload_permissions();
    }
    
    public function editUserGroup($user_group_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}user_group 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				permission = '" . (isset($data['permission']) ? serialize($data['permission']) : '') . "' 
			WHERE user_group_id = '" . (int)$user_group_id . "'
		");
        
        $this->user->reload_permissions();
    }
    
    public function deleteUserGroup($user_group_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}user_group WHERE user_group_id = '" . (int)$user_group_id . "'");
        
        $this->user->reload_permissions();
    }
    
    public function addPermission($user_id, $type, $page) {
        $user_query = $this->db->query("
			SELECT DISTINCT user_group_id 
			FROM {$this->db->prefix}user 
			WHERE user_id = '" . (int)$user_id . "'
		");
        
        if ($user_query->num_rows) {
            $user_group_query = $this->db->query("
				SELECT DISTINCT * 
				FROM {$this->db->prefix}user_group 
				WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'
			");
            
            if ($user_group_query->num_rows) {
                $data = unserialize($user_group_query->row['permission']);
                
                $data[$type][] = $page;
                
                $this->db->query("
					UPDATE {$this->db->prefix}user_group 
					SET 
						permission = '" . serialize($data) . "' 
					WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'
				");
            }
        }
        
        $this->user->reload_permissions();
    }
    
    public function getUserGroup($user_group_id) {
        $query = $this->db->query("
			SELECT DISTINCT * 
			FROM {$this->db->prefix}user_group 
			WHERE user_group_id = '" . (int)$user_group_id . "'
		");
        
        $user_group = array('name' => $query->row['name'], 'permission' => unserialize($query->row['permission']));
        
        return $user_group;
    }
    
    public function getUserGroups($data = array()) {
        $sql = "
			SELECT * 
			FROM {$this->db->prefix}user_group";
        
        $sql.= " ORDER BY name";
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql.= " DESC";
        } else {
            $sql.= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getTotalUserGroups() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}user_group");
        
        return $query->row['total'];
    }
}
