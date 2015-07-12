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

class Country extends Model {
    public function addCountry($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}country 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				iso_code_2 = '" . $this->db->escape($data['iso_code_2']) . "', 
				iso_code_3 = '" . $this->db->escape($data['iso_code_3']) . "', 
				address_format = '" . $this->db->escape($data['address_format']) . "', 
				postcode_required = '" . (int)$data['postcode_required'] . "', 
				status = '" . (int)$data['status'] . "'
		");
        
        $this->cache->delete('country');
        $this->cache->delete('countries');
    }
    
    public function editCountry($country_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}country 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				iso_code_2 = '" . $this->db->escape($data['iso_code_2']) . "', 
				iso_code_3 = '" . $this->db->escape($data['iso_code_3']) . "', 
				address_format = '" . $this->db->escape($data['address_format']) . "', 
				postcode_required = '" . (int)$data['postcode_required'] . "', 
				status = '" . (int)$data['status'] . "' 
			WHERE country_id = '" . (int)$country_id . "'
		");
        
        $this->cache->delete('country');
        $this->cache->delete('countries');
        
        // changes status of zones for this country
        Theme::model('locale/zone');
        
        $zones = $this->model_locale_zone->findZonesByCountryId($country_id);
        
        if (!empty($zones)) {
            foreach ($zones as $zone):
                $this->model_locale_zone->changeStatus($zone['zone_id'], $data['status']);
            endforeach;
        }
        
        $this->cache->delete('zone');
        $this->cache->delete('zones');
    }
    
    public function deleteCountry($country_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}country WHERE country_id = '" . (int)$country_id . "'");
        
        $this->cache->delete('country');
        $this->cache->delete('countries');
        $this->cache->delete('zone');
        $this->cache->delete('zones');
    }
    
    public function getCountry($country_id) {
        $query = $this->db->query("
			SELECT DISTINCT * 
			FROM {$this->db->prefix}country 
			WHERE country_id = '" . (int)$country_id . "'
		");
        
        return $query->row;
    }
    
    public function getCountries($data = array()) {
        if ($data) {
            $sql = "
				SELECT * FROM {$this->db->prefix}country";
            
            if (isset($data['filter_status'])):
                $sql.= " WHERE status = '" . (int)$data['filter_status'] . "'";
            endif;
            
            $sort_data = array('name', 'iso_code_2', 'iso_code_3');
            
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
            $country_data = $this->cache->get('country');
            
            if (!$country_data) {
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}country 
					ORDER BY name ASC
				");
                
                $country_data = $query->rows;
                
                $this->cache->set('country', $country_data);
            }
            
            return $country_data;
        }
    }
    
    public function getTotalCountries() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}country
		");
        
        return $query->row['total'];
    }
}
