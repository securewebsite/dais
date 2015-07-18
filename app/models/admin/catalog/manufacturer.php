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

namespace App\Models\Admin\Catalog;

use App\Models\Model;

class Manufacturer extends Model {
    
    public function addManufacturer($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "manufacturer 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				sort_order = '" . (int)$data['sort_order'] . "'
		");
        
        $manufacturer_id = DB::getLastId();
        
        if (isset($data['image'])) {
            DB::query("
				UPDATE " . DB::prefix() . "manufacturer 
				SET 
					image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE manufacturer_id = '" . (int)$manufacturer_id . "'
			");
        }
        
        if (isset($data['manufacturer_store'])) {
            foreach ($data['manufacturer_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "manufacturer_to_store 
					SET 
						manufacturer_id = '" . (int)$manufacturer_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
					route = 'catalog/manufacturer/info', 
					query = 'manufacturer_id:" . (int)$manufacturer_id . "', 
					slug = '" . DB::escape($data['slug']) . "'
			");
        }

        $this->search->add(Config::get('config_language_id'), 'manufacturer', $manufacturer_id, $data['name']);
        
        Cache::delete('manufacturer');
        
        Theme::trigger('admin_add_manufacturer', array('manufacturer_id' => $manufacturer_id));
    }
    
    public function editManufacturer($manufacturer_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "manufacturer 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				sort_order = '" . (int)$data['sort_order'] . "' 
			WHERE manufacturer_id = '" . (int)$manufacturer_id . "'
		");
        
        if (isset($data['image'])) {
            DB::query("
				UPDATE " . DB::prefix() . "manufacturer 
				SET 
					image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE manufacturer_id = '" . (int)$manufacturer_id . "'
			");
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "manufacturer_to_store 
            WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
        
        if (isset($data['manufacturer_store'])) {
            foreach ($data['manufacturer_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "manufacturer_to_store 
					SET 
						manufacturer_id = '" . (int)$manufacturer_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'manufacturer_id:" . (int)$manufacturer_id . "'");
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
					route = 'catalog/manufacturer/info', 
					query = 'manufacturer_id:" . (int)$manufacturer_id . "', 
					slug = '" . DB::escape($data['slug']) . "'
			");
        }

        // delete
        $this->search->delete('manufacturer', $manufacturer_id);

        // insert
        $this->search->add(Config::get('config_language_id'), 'manufacturer', $manufacturer_id, $data['name']);
        
        Cache::delete('manufacturer');
        
        Theme::trigger('admin_edit_manufacturer', array('manufacturer_id' => $manufacturer_id));
    }
    
    public function deleteManufacturer($manufacturer_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "manufacturer 
            WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "manufacturer_to_store 
            WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'manufacturer_id:" . (int)$manufacturer_id . "'");
        
        $this->search->delete('manufacturer', $manufacturer_id);

        Cache::delete('manufacturer');
        
        Theme::trigger('admin_delete_manufacturer', array('manufacturer_id' => $manufacturer_id));
    }
    
    public function getManufacturer($manufacturer_id) {
        $query = DB::query("
			SELECT DISTINCT *, 
			(SELECT slug 
				FROM " . DB::prefix() . "route 
				WHERE query = 'manufacturer_id:" . (int)$manufacturer_id . "') AS slug 
			FROM " . DB::prefix() . "manufacturer 
			WHERE manufacturer_id = '" . (int)$manufacturer_id . "'
		");
        
        return $query->row;
    }
    
    public function getManufacturers($data = array()) {
        $sql = "
            SELECT * 
            FROM " . DB::prefix() . "manufacturer";
        
        if (!empty($data['filter_name'])) {
            $filter = DB::escape($data['filter_name']);
            $sql.= " WHERE name LIKE {$filter}%";
        }
        
        $sort_data = array('name', 'sort_order');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY name";
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
    }
    
    public function getManufacturerStores($manufacturer_id) {
        $manufacturer_store_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "manufacturer_to_store 
			WHERE manufacturer_id = '" . (int)$manufacturer_id . "'
		");
        
        foreach ($query->rows as $result) {
            $manufacturer_store_data[] = $result['store_id'];
        }
        
        return $manufacturer_store_data;
    }
    
    public function getTotalManufacturersByImageId($image_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "manufacturer 
			WHERE image_id = '" . (int)$image_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalManufacturers() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "manufacturer
		");
        
        return $query->row['total'];
    }
}
