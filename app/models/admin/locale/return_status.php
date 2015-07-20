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

namespace App\Models\Admin\Locale;

use App\Models\Model;

class ReturnStatus extends Model {
    
    public function addReturnStatus($data) {
        foreach ($data['return_status'] as $language_id => $value) {
            if (isset($return_status_id)) {
                DB::query("
					INSERT INTO " . DB::prefix() . "return_status 
					SET 
						return_status_id = '" . (int)$return_status_id . "', 
						language_id = '" . (int)$language_id . "', 
						name = '" . DB::escape($value['name']) . "'
				");
            } else {
                DB::query("
					INSERT INTO " . DB::prefix() . "return_status 
					SET 
						language_id = '" . (int)$language_id . "', 
						name = '" . DB::escape($value['name']) . "'
				");
                
                $return_status_id = DB::getLastId();
            }
        }
    }
    
    public function editReturnStatus($return_status_id, $data) {
        DB::query("DELETE FROM " . DB::prefix() . "return_status WHERE return_status_id = '" . (int)$return_status_id . "'");
        
        foreach ($data['return_status'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "return_status 
				SET 
					return_status_id = '" . (int)$return_status_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "'
			");
        }
    }
    
    public function deleteReturnStatus($return_status_id) {
        DB::query("DELETE FROM " . DB::prefix() . "return_status WHERE return_status_id = '" . (int)$return_status_id . "'");
    }
    
    public function getReturnStatus($return_status_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_status 
			WHERE return_status_id = '" . (int)$return_status_id . "' 
			AND language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getReturnStatuses($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "return_status 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "'";
            
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
        } else {
            $query = DB::query("
				SELECT 
					return_status_id, 
					name 
				FROM " . DB::prefix() . "return_status 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY name
			");
            
            $return_status_data = $query->rows;
            
            return $return_status_data;
        }
    }
    
    public function getReturnStatusDescriptions($return_status_id) {
        $return_status_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_status 
			WHERE return_status_id = '" . (int)$return_status_id . "'
		");
        
        foreach ($query->rows as $result) {
            $return_status_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $return_status_data;
    }
    
    public function getTotalReturnStatuses() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "return_status 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row['total'];
    }
}
