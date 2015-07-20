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

class ReturnReason extends Model {
    
    public function addReturnReason($data) {
        foreach ($data['return_reason'] as $language_id => $value) {
            if (isset($return_reason_id)) {
                DB::query("
					INSERT INTO " . DB::prefix() . "return_reason 
					SET 
						return_reason_id = '" . (int)$return_reason_id . "', 
						language_id = '" . (int)$language_id . "', 
						name = '" . DB::escape($value['name']) . "'
				");
            } else {
                DB::query("
					INSERT INTO " . DB::prefix() . "return_reason 
					SET 
						language_id = '" . (int)$language_id . "', 
						name = '" . DB::escape($value['name']) . "'
				");
                
                $return_reason_id = DB::getLastId();
            }
        }
        
        Cache::delete('return.reason');
        Cache::delete('return.reasons');
    }
    
    public function editReturnReason($return_reason_id, $data) {
        DB::query("DELETE FROM " . DB::prefix() . "return_reason WHERE return_reason_id = '" . (int)$return_reason_id . "'");
        
        foreach ($data['return_reason'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "return_reason 
				SET 
					return_reason_id = '" . (int)$return_reason_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "'
			");
        }
        
        Cache::delete('return.reason');
        Cache::delete('return.reasons');
    }
    
    public function deleteReturnReason($return_reason_id) {
        DB::query("DELETE FROM " . DB::prefix() . "return_reason WHERE return_reason_id = '" . (int)$return_reason_id . "'");
        
        Cache::delete('return.reason');
        Cache::delete('return.reasons');
    }
    
    public function getReturnReason($return_reason_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_reason 
			WHERE return_reason_id = '" . (int)$return_reason_id . "' 
			AND language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getReturnReasons($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "return_reason 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "'
			";
            
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
					return_reason_id, 
					name 
				FROM " . DB::prefix() . "return_reason 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY name
			");
            
            return $query->rows;
        }
    }
    
    public function getReturnReasonDescriptions($return_reason_id) {
        $return_reason_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_reason 
			WHERE return_reason_id = '" . (int)$return_reason_id . "'
		");
        
        foreach ($query->rows as $result) {
            $return_reason_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $return_reason_data;
    }
    
    public function getTotalReturnReasons() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "return_reason 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row['total'];
    }
}
