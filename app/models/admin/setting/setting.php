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

namespace App\Models\Admin\Setting;

use App\Models\Model;

class Setting extends Model {
    
    public function getSetting($group, $store_id = 0) {
        $data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "setting 
			WHERE store_id = '" . (int)$store_id . "' 
			AND section = '" . DB::escape($group) . "'
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
                DB::query("
					INSERT INTO " . DB::prefix() . "setting 
					SET 
						store_id = '" . (int)$store_id . "', 
						section = '" . DB::escape($group) . "', 
						item = '" . DB::escape($key) . "', 
						data = '" . DB::escape($value) . "'
				");
            else:
                DB::query("
					INSERT INTO " . DB::prefix() . "setting 
					SET 
						store_id = '" . (int)$store_id . "', 
						section = '" . DB::escape($group) . "', 
						item = '" . DB::escape($key) . "', 
						data = '" . DB::escape(serialize($value)) . "', 
						serialized = '1'
				");
            endif;
        endforeach;
        
        Cache::delete('default');
    }
    
    public function deleteSetting($group, $store_id = 0) {
        DB::query("
			DELETE FROM " . DB::prefix() . "setting 
			WHERE store_id = '" . (int)$store_id . "' 
			AND section = '" . DB::escape($group) . "'
		");
        
        Cache::delete('default');
    }
    
    public function getSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
        $query = DB::query("
			SELECT data 
			FROM " . DB::prefix() . "setting 
			WHERE section = '" . DB::escape($group) . "' 
			AND item = '" . DB::escape($key) . "' 
			AND store_id = '" . (int)$store_id . "'");
        
        if ($query->num_rows):
            return true;
        else:
            return false;
        endif;
    }
    
    public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
        if (!is_array($value)) {
            DB::query("
				UPDATE " . DB::prefix() . "setting 
				SET 
					data = '" . DB::escape($value) . "' 
				WHERE section = '" . DB::escape($group) . "' 
				AND item = '" . DB::escape($key) . "' 
				AND store_id = '" . (int)$store_id . "'
			");
        } else {
            DB::query("
				UPDATE " . DB::prefix() . "setting 
				SET 
					data = '" . DB::escape(serialize($value)) . "' 
				WHERE section = '" . DB::escape($group) . "' 
				AND item = '" . DB::escape($key) . "' 
				AND store_id = '" . (int)$store_id . "', 
				serialized = '1'
			");
        }
        
        Cache::delete('default');
    }
}
