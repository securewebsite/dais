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

namespace App\Models\Front\Catalog;
use App\Models\Model;

class Manufacturer extends Model {
    public function getManufacturer($manufacturer_id) {
        $key = 'manufacturer.' . $manufacturer_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}manufacturer m 
				LEFT JOIN {$this->db->prefix}manufacturer_to_store m2s 
					ON (m.manufacturer_id = m2s.manufacturer_id) 
				WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' 
				AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row;
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getManufacturers($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM {$this->db->prefix}manufacturer m 
				LEFT JOIN {$this->db->prefix}manufacturer_to_store m2s 
				ON (m.manufacturer_id = m2s.manufacturer_id) 
				WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
            
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
            
            $query = $this->db->query($sql);
            
            return $query->rows;
        } else {
            $key = 'manufacturer.all.' . (int)$this->config->get('config_store_id');
            $manufacturer_data = $this->cache->get($key);
            
            if (!$manufacturer_data) {
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}manufacturer m 
					LEFT JOIN {$this->db->prefix}manufacturer_to_store m2s 
					ON (m.manufacturer_id = m2s.manufacturer_id) 
					WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
					ORDER BY name
				");
                
                $manufacturer_data = $query->rows;
                
                $this->cache->set($key, $manufacturer_data);
            }
            
            return $manufacturer_data;
        }
    }
}
