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

class OrderStatus extends Model {
    
    public function addOrderStatus($data) {
        foreach ($data['order_status'] as $language_id => $value) {
            if (isset($order_status_id)) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_status 
					SET 
						order_status_id = '" . (int)$order_status_id . "', 
						language_id = '" . (int)$language_id . "', 
						name = '" . $this->db->escape($value['name']) . "'
				");
            } else {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_status 
					SET 
						language_id = '" . (int)$language_id . "', 
						name = '" . $this->db->escape($value['name']) . "'
				");
                
                $order_status_id = $this->db->getLastId();
            }
        }
    }
    
    public function editOrderStatus($order_status_id, $data) {
        $this->db->query("DELETE FROM {$this->db->prefix}order_status WHERE order_status_id = '" . (int)$order_status_id . "'");
        
        foreach ($data['order_status'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}order_status 
				SET 
					order_status_id = '" . (int)$order_status_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . $this->db->escape($value['name']) . "'
			");
        }
    }
    
    public function deleteOrderStatus($order_status_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}order_status WHERE order_status_id = '" . (int)$order_status_id . "'");
    }
    
    public function getOrderStatus($order_status_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_status 
			WHERE order_status_id = '" . (int)$order_status_id . "' 
			AND language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getOrderStatuses($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM {$this->db->prefix}order_status 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "'
			";
            
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
            
            $query = $this->db->query($sql);
            
            return $query->rows;
        } else {
            $query = $this->db->query("
				SELECT 
					order_status_id, 
					name 
				FROM {$this->db->prefix}order_status 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY name
			");
            
            $order_status_data = $query->rows;
            
            return $order_status_data;
        }
    }
    
    public function getOrderStatusDescriptions($order_status_id) {
        $order_status_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_status 
			WHERE order_status_id = '" . (int)$order_status_id . "'
		");
        
        foreach ($query->rows as $result) {
            $order_status_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $order_status_data;
    }
    
    public function getTotalOrderStatuses() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}order_status 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row['total'];
    }
    
    public function getMenuStatusDescription($order_status_id) {
        $query = $this->db->query("
			SELECT name 
			FROM {$this->db->prefix}order_status 
			WHERE language_id='" . (int)Config::get('config_language_id') . "' 
			AND order_status_id='" . (int)$order_status_id . "'
		");
        
        return $query->row['name'];
    }
}
