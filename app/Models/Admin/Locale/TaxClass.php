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

class TaxClass extends Model {
    public function addTaxClass($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}tax_class 
			SET 
				title = '" . $this->db->escape($data['title']) . "', 
				description = '" . $this->db->escape($data['description']) . "', 
				date_added = NOW()
		");
        
        $tax_class_id = $this->db->getLastId();
        
        if (isset($data['tax_rule'])) {
            foreach ($data['tax_rule'] as $tax_rule) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}tax_rule 
					SET 
						tax_class_id = '" . (int)$tax_class_id . "', 
						tax_rate_id = '" . (int)$tax_rule['tax_rate_id'] . "', 
						based = '" . $this->db->escape($tax_rule['based']) . "', 
						priority = '" . (int)$tax_rule['priority'] . "'
				");
            }
        }
        
        $this->cache->delete('shipping.address.tax');
        $this->cache->delete('payment.address.tax');
        $this->cache->delete('store.address.tax');
        $this->cache->delete('tax.rate.name');
    }
    
    public function editTaxClass($tax_class_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}tax_class 
			SET 
				title = '" . $this->db->escape($data['title']) . "', 
				description = '" . $this->db->escape($data['description']) . "', 
				date_modified = NOW() 
			WHERE tax_class_id = '" . (int)$tax_class_id . "'
		");
        
        $this->db->query("DELETE FROM {$this->db->prefix}tax_rule WHERE tax_class_id = '" . (int)$tax_class_id . "'");
        
        if (isset($data['tax_rule'])) {
            foreach ($data['tax_rule'] as $tax_rule) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}tax_rule 
					SET 
						tax_class_id = '" . (int)$tax_class_id . "', 
						tax_rate_id = '" . (int)$tax_rule['tax_rate_id'] . "', 
						based = '" . $this->db->escape($tax_rule['based']) . "', 
						priority = '" . (int)$tax_rule['priority'] . "'
				");
            }
        }
        
        $this->cache->delete('shipping.address.tax');
        $this->cache->delete('payment.address.tax');
        $this->cache->delete('store.address.tax');
        $this->cache->delete('tax.rate.name');
    }
    
    public function deleteTaxClass($tax_class_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}tax_class WHERE tax_class_id = '" . (int)$tax_class_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}tax_rule WHERE tax_class_id = '" . (int)$tax_class_id . "'");
        
        $this->cache->delete('shipping.address.tax');
        $this->cache->delete('payment.address.tax');
        $this->cache->delete('store.address.tax');
        $this->cache->delete('tax.rate.name');
    }
    
    public function getTaxClass($tax_class_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}tax_class 
			WHERE tax_class_id = '" . (int)$tax_class_id . "'
		");
        
        return $query->row;
    }
    
    public function getTaxClasses($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM {$this->db->prefix}tax_class";
            
            $sql.= " ORDER BY title";
            
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
				SELECT * 
				FROM {$this->db->prefix}tax_class");
            
            return $query->rows;
        }
    }
    
    public function getTotalTaxClasses() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}tax_class");
        
        return $query->row['total'];
    }
    
    public function getTaxRules($tax_class_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}tax_rule 
			WHERE tax_class_id = '" . (int)$tax_class_id . "'");
        
        return $query->rows;
    }
    
    public function getTotalTaxRulesByTaxRateId($tax_rate_id) {
        $query = $this->db->query("
			SELECT COUNT(DISTINCT tax_class_id) AS total 
			FROM {$this->db->prefix}tax_rule 
			WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
        
        return $query->row['total'];
    }
}
