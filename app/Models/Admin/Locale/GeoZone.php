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

class GeoZone extends Model {
    public function addGeoZone($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}geo_zone 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				description = '" . $this->db->escape($data['description']) . "', 
				date_added = NOW()
			");
        
        $geo_zone_id = $this->db->getLastId();
        
        if (isset($data['zone_to_geo_zone'])) {
            foreach ($data['zone_to_geo_zone'] as $value) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}zone_to_geo_zone 
					SET 
						country_id = '" . (int)$value['country_id'] . "', 
						zone_id = '" . (int)$value['zone_id'] . "', 
						geo_zone_id = '" . (int)$geo_zone_id . "', 
						date_added = NOW()
				");
            }
        }
        
        $this->cache->delete('geo_zone');
    }
    
    public function editGeoZone($geo_zone_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}geo_zone 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				description = '" . $this->db->escape($data['description']) . "', 
				date_modified = NOW() 
			WHERE geo_zone_id = '" . (int)$geo_zone_id . "'
		");
        
        $this->db->query("DELETE FROM {$this->db->prefix}zone_to_geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        if (isset($data['zone_to_geo_zone'])) {
            foreach ($data['zone_to_geo_zone'] as $value) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}zone_to_geo_zone 
					SET 
						country_id = '" . (int)$value['country_id'] . "', 
						zone_id = '" . (int)$value['zone_id'] . "', 
						geo_zone_id = '" . (int)$geo_zone_id . "', date_added = NOW()
				");
            }
        }
        
        $this->cache->delete('geo_zone');
    }
    
    public function deleteGeoZone($geo_zone_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}zone_to_geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        $this->cache->delete('geo_zone');
    }
    
    public function getGeoZone($geo_zone_id) {
        $query = $this->db->query("
			SELECT DISTINCT * 
			FROM {$this->db->prefix}geo_zone 
			WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        return $query->row;
    }
    
    public function getGeoZones($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM {$this->db->prefix}geo_zone";
            
            $sort_data = array('name', 'description');
            
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
            
            $query = $this->db->query($sql);
            
            return $query->rows;
        } else {
            $geo_zone_data = $this->cache->get('geo_zone');
            
            if (!$geo_zone_data) {
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}geo_zone 
					ORDER BY name ASC");
                
                $geo_zone_data = $query->rows;
                
                $this->cache->set('geo_zone', $geo_zone_data);
            }
            
            return $geo_zone_data;
        }
    }
    
    public function getTotalGeoZones() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}geo_zone");
        
        return $query->row['total'];
    }
    
    public function getZoneToGeoZones($geo_zone_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}zone_to_geo_zone 
			WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        return $query->rows;
    }
    
    public function getGeoZonesByCountryId($country_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}zone_to_geo_zone 
			WHERE country_id = '" . (int)$country_id . "'");
        
        return $query->rows;
    }
    
    public function getTotalZoneToGeoZoneByGeoZoneId($geo_zone_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}zone_to_geo_zone 
			WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalZoneToGeoZoneByCountryId($country_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}zone_to_geo_zone 
			WHERE country_id = '" . (int)$country_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalZoneToGeoZoneByZoneId($zone_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}zone_to_geo_zone 
			WHERE zone_id = '" . (int)$zone_id . "'");
        
        return $query->row['total'];
    }
}
