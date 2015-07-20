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
        DB::query("
			INSERT INTO " . DB::prefix() . "country 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				iso_code_2 = '" . DB::escape($data['iso_code_2']) . "', 
				iso_code_3 = '" . DB::escape($data['iso_code_3']) . "', 
				address_format = '" . DB::escape($data['address_format']) . "', 
				postcode_required = '" . (int)$data['postcode_required'] . "', 
				status = '" . (int)$data['status'] . "'
		");
        
        Cache::delete('country');
        Cache::delete('countries');
    }
    
    public function editCountry($country_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "country 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				iso_code_2 = '" . DB::escape($data['iso_code_2']) . "', 
				iso_code_3 = '" . DB::escape($data['iso_code_3']) . "', 
				address_format = '" . DB::escape($data['address_format']) . "', 
				postcode_required = '" . (int)$data['postcode_required'] . "', 
				status = '" . (int)$data['status'] . "' 
			WHERE country_id = '" . (int)$country_id . "'
		");
        
        Cache::delete('country');
        Cache::delete('countries');
        
        // changes status of zones for this country
        Theme::model('locale/zone');
        
        $zones = LocaleZone::findZonesByCountryId($country_id);
        
        if (!empty($zones)) {
            foreach ($zones as $zone):
                LocaleZone::changeStatus($zone['zone_id'], $data['status']);
            endforeach;
        }
        
        Cache::delete('zone');
        Cache::delete('zones');
    }
    
    public function deleteCountry($country_id) {
        DB::query("DELETE FROM " . DB::prefix() . "country WHERE country_id = '" . (int)$country_id . "'");
        
        Cache::delete('country');
        Cache::delete('countries');
        Cache::delete('zone');
        Cache::delete('zones');
    }
    
    public function getCountry($country_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "country 
			WHERE country_id = '" . (int)$country_id . "'
		");
        
        return $query->row;
    }
    
    public function getCountries($data = array()) {
        if ($data) {
            $sql = "
				SELECT * FROM " . DB::prefix() . "country";
            
            if (isset($data['filter_status'])):
                $sql.= " WHERE status = '" . (int)$data['filter_status'] . "'";
            endif;
            
            $sort_data = array('name', 'iso_code_2', 'iso_code_3');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql.= " ORDER BY {$data['sort']}";
            } else {
                $sql.= " ORDER BY name";
            }
            
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
            $country_data = Cache::get('country');
            
            if (!$country_data) {
                $query = DB::query("
					SELECT * 
					FROM " . DB::prefix() . "country 
					ORDER BY name ASC
				");
                
                $country_data = $query->rows;
                
                Cache::set('country', $country_data);
            }
            
            return $country_data;
        }
    }
    
    public function getTotalCountries() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "country
		");
        
        return $query->row['total'];
    }
}
