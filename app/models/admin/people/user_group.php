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

namespace App\Models\Admin\People;

use App\Models\Model;

class UserGroup extends Model {
    
    public function addUserGroup($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "user_group 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				permission = '" . (isset($data['permission']) ? serialize($data['permission']) : '') . "'
		");
        
        \User::reload_permissions();
    }
    
    public function editUserGroup($user_group_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "user_group 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				permission = '" . (isset($data['permission']) ? serialize($data['permission']) : '') . "' 
			WHERE user_group_id = '" . (int)$user_group_id . "'
		");
        
        \User::reload_permissions();
    }
    
    public function deleteUserGroup($user_group_id) {
        DB::query("DELETE FROM " . DB::prefix() . "user_group WHERE user_group_id = '" . (int)$user_group_id . "'");
        
        \User::reload_permissions();
    }
    
    public function addPermission($user_id, $type, $page) {
        $user_query = DB::query("
			SELECT DISTINCT user_group_id 
			FROM " . DB::prefix() . "user 
			WHERE user_id = '" . (int)$user_id . "'
		");
        
        if ($user_query->num_rows) {
            $user_group_query = DB::query("
				SELECT DISTINCT * 
				FROM " . DB::prefix() . "user_group 
				WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'
			");
            
            if ($user_group_query->num_rows) {
                $data = unserialize($user_group_query->row['permission']);
                
                $data[$type][] = $page;
                
                DB::query("
					UPDATE " . DB::prefix() . "user_group 
					SET 
						permission = '" . serialize($data) . "' 
					WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'
				");
            }
        }
        
        \User::reload_permissions();
    }
    
    public function getUserGroup($user_group_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "user_group 
			WHERE user_group_id = '" . (int)$user_group_id . "'
		");
        
        $user_group = array('name' => $query->row['name'], 'permission' => unserialize($query->row['permission']));
        
        return $user_group;
    }
    
    public function getUserGroups($data = array()) {
        $sql = "
			SELECT * 
			FROM " . DB::prefix() . "user_group";
        
        $sql.= " ORDER BY name";
        
        if (isset($data['order']) && ($data['order'] == 'desc')) {
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
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function getTotalUserGroups() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "user_group");
        
        return $query->row['total'];
    }
}
