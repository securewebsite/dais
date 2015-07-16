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

class WeightClass extends Model {
    
    public function addWeightClass($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "weight_class 
			SET 
				value = '" . (float)$data['value'] . "'");
        
        $weight_class_id = DB::getLastId();
        
        foreach ($data['weight_class_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "weight_class_description 
				SET 
					weight_class_id = '" . (int)$weight_class_id . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . DB::escape($value['title']) . "', 
					unit = '" . DB::escape($value['unit']) . "'
			");
        }
        
        Cache::delete('default.store.weights');
    }
    
    public function editWeightClass($weight_class_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "weight_class 
			SET 
				value = '" . (float)$data['value'] . "' 
			WHERE weight_class_id = '" . (int)$weight_class_id . "'
		");
        
        DB::query("DELETE FROM " . DB::prefix() . "weight_class_description WHERE weight_class_id = '" . (int)$weight_class_id . "'");
        
        foreach ($data['weight_class_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "weight_class_description 
				SET 
					weight_class_id = '" . (int)$weight_class_id . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . DB::escape($value['title']) . "', 
					unit = '" . DB::escape($value['unit']) . "'
			");
        }
        
        Cache::delete('default.store.weights');
    }
    
    public function deleteWeightClass($weight_class_id) {
        DB::query("DELETE FROM " . DB::prefix() . "weight_class WHERE weight_class_id = '" . (int)$weight_class_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "weight_class_description WHERE weight_class_id = '" . (int)$weight_class_id . "'");
        
        Cache::delete('default.store.weights');
    }
    
    public function getWeightClasses($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "weight_class wc 
				LEFT JOIN " . DB::prefix() . "weight_class_description wcd 
					ON (wc.weight_class_id = wcd.weight_class_id) 
				WHERE wcd.language_id = '" . (int)Config::get('config_language_id') . "'";
            
            $sort_data = array('title', 'unit', 'value');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql.= " ORDER BY {$data['sort']}";
            } else {
                $sql.= " ORDER BY title";
            }
            
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
				SELECT * 
				FROM " . DB::prefix() . "weight_class wc 
				LEFT JOIN " . DB::prefix() . "weight_class_description wcd 
					ON (wc.weight_class_id = wcd.weight_class_id) 
				WHERE wcd.language_id = '" . (int)Config::get('config_language_id') . "'
			");
            
            return $query->rows;
        }
    }
    
    public function getWeightClass($weight_class_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "weight_class wc 
			LEFT JOIN " . DB::prefix() . "weight_class_description wcd 
				ON (wc.weight_class_id = wcd.weight_class_id) 
			WHERE wc.weight_class_id = '" . (int)$weight_class_id . "' 
			AND wcd.language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getWeightClassDescriptionByUnit($unit) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "weight_class_description 
			WHERE unit = '" . DB::escape($unit) . "' 
			AND language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getWeightClassDescriptions($weight_class_id) {
        $weight_class_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "weight_class_description 
			WHERE weight_class_id = '" . (int)$weight_class_id . "'
		");
        
        foreach ($query->rows as $result) {
            $weight_class_data[$result['language_id']] = array('title' => $result['title'], 'unit' => $result['unit']);
        }
        
        return $weight_class_data;
    }
    
    public function getTotalWeightClasses() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "weight_class");
        
        return $query->row['total'];
    }
}
