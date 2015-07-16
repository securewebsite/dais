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

class StockStatus extends Model {
    
    public function addStockStatus($data) {
        foreach ($data['stock_status'] as $language_id => $value) {
            if (isset($stock_status_id)) {
                DB::query("
					INSERT INTO " . DB::prefix() . "stock_status 
					SET 
						stock_status_id = '" . (int)$stock_status_id . "', 
						language_id = '" . (int)$language_id . "', 
						name = '" . DB::escape($value['name']) . "'
				");
            } else {
                DB::query("
					INSERT INTO " . DB::prefix() . "stock_status 
					SET 
						language_id = '" . (int)$language_id . "', 
						name = '" . DB::escape($value['name']) . "'
				");
                
                $stock_status_id = DB::getLastId();
            }
        }
    }
    
    public function editStockStatus($stock_status_id, $data) {
        DB::query("DELETE FROM " . DB::prefix() . "stock_status WHERE stock_status_id = '" . (int)$stock_status_id . "'");
        
        foreach ($data['stock_status'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "stock_status 
				SET 
					stock_status_id = '" . (int)$stock_status_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "'
			");
        }
    }
    
    public function deleteStockStatus($stock_status_id) {
        DB::query("DELETE FROM " . DB::prefix() . "stock_status WHERE stock_status_id = '" . (int)$stock_status_id . "'");
    }
    
    public function getStockStatus($stock_status_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "stock_status 
			WHERE stock_status_id = '" . (int)$stock_status_id . "' 
			AND language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getStockStatuses($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "stock_status 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "'";
            
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
            
            $query = DB::query($sql);
            
            return $query->rows;
        } else {
            $query = DB::query("
				SELECT 
					stock_status_id, 
					name 
				FROM " . DB::prefix() . "stock_status 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY name
			");
            
            return $query->rows;
        }
    }
    
    public function getStockStatusDescriptions($stock_status_id) {
        $stock_status_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "stock_status 
			WHERE stock_status_id = '" . (int)$stock_status_id . "'");
        
        foreach ($query->rows as $result) {
            $stock_status_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $stock_status_data;
    }
    
    public function getTotalStockStatuses() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "stock_status 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row['total'];
    }
}
