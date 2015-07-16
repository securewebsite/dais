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

class Zone extends Model {
    
    public function addZone($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "zone 
			SET 
				status = '" . (int)$data['status'] . "', 
				name = '" . DB::escape($data['name']) . "', 
				code = '" . DB::escape($data['code']) . "', 
				country_id = '" . (int)$data['country_id'] . "'
		");
        
        Cache::delete('zone');
        Cache::delete('zones');
    }
    
    public function editZone($zone_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "zone 
			SET 
				status = '" . (int)$data['status'] . "', 
				name = '" . DB::escape($data['name']) . "', 
				code = '" . DB::escape($data['code']) . "', 
				country_id = '" . (int)$data['country_id'] . "' 
			WHERE zone_id = '" . (int)$zone_id . "'
		");
        
        Cache::delete('zone');
        Cache::delete('zones');
    }
    
    public function changeStatus($zone_id, $status) {
        DB::query("
			UPDATE " . DB::prefix() . "zone 
			SET 
				status = '" . (int)$status . "' 
			WHERE zone_id = '" . (int)$zone_id . "'
		");
        
        Cache::delete('zone');
        Cache::delete('zones');
    }
    
    public function deleteZone($zone_id) {
        DB::query("DELETE FROM " . DB::prefix() . "zone WHERE zone_id = '" . (int)$zone_id . "'");
        
        Cache::delete('zone');
        Cache::delete('zones');
    }
    
    public function getZone($zone_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "zone 
			WHERE zone_id = '" . (int)$zone_id . "'
		");
        
        return $query->row;
    }
    
    public function getZones($data = array()) {
        $sql = "
			SELECT *, 
				z.name, 
				c.name AS country 
			FROM " . DB::prefix() . "zone z 
			LEFT JOIN " . DB::prefix() . "country c 
				ON (z.country_id = c.country_id)";
        
        $sort_data = array('c.name', 'z.name', 'z.code');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY c.name";
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
    
    public function getZonesByCountryId($country_id) {
        $zone_data = Cache::get('zone.' . (int)$country_id);
        
        if (!$zone_data) {
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "zone 
				WHERE country_id = '" . (int)$country_id . "' 
				AND status = '1' 
				ORDER BY name
			");
            
            $zone_data = $query->rows;
            
            Cache::set('zone.' . (int)$country_id, $zone_data);
        }
        
        return $zone_data;
    }
    
    public function findZonesByCountryId($country_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "zone 
			WHERE country_id = '" . (int)$country_id . "' 
			ORDER BY name
		");
        
        return $query->rows;
    }
    
    public function getTotalZones() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "zone");
        
        return $query->row['total'];
    }
    
    public function getTotalZonesByCountryId($country_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "zone 
			WHERE country_id = '" . (int)$country_id . "'
		");
        
        return $query->row['total'];
    }
}
