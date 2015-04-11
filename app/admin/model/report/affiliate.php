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

namespace Admin\Model\Report;
use Dais\Engine\Model;

class Affiliate extends Model {
    public function getCommission($data = array()) {
        $sql = "
            SELECT 
                cc.customer_id, 
                CONCAT(c.firstname, ' ', c.lastname) AS affiliate, 
                c.email, 
                c.status, 
                SUM(cc.amount) AS commission, 
                COUNT(o.order_id) AS orders, 
                SUM(o.total) AS total 
            FROM {$this->db->prefix}customer_commission cc 
            LEFT JOIN {$this->db->prefix}customer c 
            ON (cc.customer_id = c.customer_id) 
            LEFT JOIN `{$this->db->prefix}order` o 
            ON (cc.order_id = o.order_id)";
        
        $implode = array();
        
        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(cc.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(cc.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        }
        
        $sql.= " GROUP BY cc.customer_id ORDER BY commission DESC";
        
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
    }
    
    public function getTotalCommission() {
        $sql = "
            SELECT COUNT(DISTINCT customer_id) AS total 
            FROM `{$this->db->prefix}customer_commission`";
        
        $implode = array();
        
        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
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
        
        return $query->row['total'];
    }
}
