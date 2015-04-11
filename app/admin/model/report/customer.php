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

class Customer extends Model {
    public function getOrders($data = array()) {
        $sql = "
            SELECT 
                tmp.customer_id, 
                tmp.customer, 
                tmp.email, 
                tmp.customer_group, 
                tmp.status, 
                COUNT(tmp.order_id) AS orders, 
                SUM(tmp.products) AS products, 
                SUM(tmp.total) AS total 
            FROM (
                SELECT 
                    o.order_id, 
                    c.customer_id, 
                    CONCAT(o.firstname, ' ', o.lastname) AS customer, 
                    o.email, 
                    cgd.name AS customer_group, 
                    c.status, 
                    (SELECT SUM(op.quantity) 
                        FROM `{$this->db->prefix}order_product` op 
                        WHERE op.order_id = o.order_id 
                        GROUP BY op.order_id) AS products, 
                    o.total 
                FROM `{$this->db->prefix}order` o 
                LEFT JOIN `{$this->db->prefix}customer` c 
                ON (o.customer_id = c.customer_id) 
                LEFT JOIN {$this->db->prefix}customer_group_description cgd 
                ON (c.customer_group_id = cgd.customer_group_id) 
                WHERE o.customer_id > 0 
                AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        
        if (!empty($data['filter_order_status_id'])) {
            $sql.= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql.= " AND o.order_status_id > '0'";
        }
        
        if (!empty($data['filter_date_start'])) {
            $sql.= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $sql.= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        
        $sql.= ") tmp GROUP BY tmp.customer_id ORDER BY total DESC";
        
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
    
    public function getTotalOrders($data = array()) {
        $sql = "
            SELECT COUNT(DISTINCT o.customer_id) AS total 
            FROM `{$this->db->prefix}order` o 
            WHERE o.customer_id > '0'";
        
        if (!empty($data['filter_order_status_id'])) {
            $sql.= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql.= " AND o.order_status_id > '0'";
        }
        
        if (!empty($data['filter_date_start'])) {
            $sql.= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $sql.= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        
        $query = $this->db->query($sql);
        
        return $query->row['total'];
    }
    
    public function getRewardPoints($data = array()) {
        $sql = "
            SELECT 
                cr.customer_id, 
                CONCAT(c.firstname, ' ', c.lastname) AS customer, 
                c.email, 
                cgd.name AS customer_group, 
                c.status, 
                SUM(cr.points) AS points, 
                COUNT(o.order_id) AS orders, 
                SUM(o.total) AS total 
            FROM {$this->db->prefix}customer_reward cr 
            LEFT JOIN `{$this->db->prefix}customer` c 
                ON (cr.customer_id = c.customer_id) 
            LEFT JOIN {$this->db->prefix}customer_group_description cgd 
                ON (c.customer_group_id = cgd.customer_group_id) 
            LEFT JOIN `{$this->db->prefix}order` o 
                ON (cr.order_id = o.order_id) 
            WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        
        if (!empty($data['filter_date_start'])) {
            $sql.= " AND DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $sql.= " AND DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        
        $sql.= " GROUP BY cr.customer_id ORDER BY points DESC";
        
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
    
    public function getTotalRewardPoints() {
        $sql = "
            SELECT COUNT(DISTINCT customer_id) AS total 
            FROM `{$this->db->prefix}customer_reward`";
        
        $implode = array();
        
        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
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
    
    public function getCredit($data = array()) {
        $sql = "
            SELECT 
                cc.customer_id, 
                CONCAT(c.firstname, ' ', c.lastname) AS customer, 
                c.email, 
                cgd.name AS customer_group, 
                c.status, 
                SUM(cc.amount) AS total 
            FROM {$this->db->prefix}customer_credit cc 
            LEFT JOIN `{$this->db->prefix}customer` c 
            ON (cc.customer_id = c.customer_id) 
            LEFT JOIN {$this->db->prefix}customer_group_description cgd 
            ON (c.customer_group_id = cgd.customer_group_id) 
            WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        
        if (!empty($data['filter_date_start'])) {
            $sql.= "DATE(cc.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $sql.= "DATE(cc.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        
        $sql.= " GROUP BY cc.customer_id ORDER BY total DESC";
        
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
    
    public function getTotalCredit() {
        $sql = "
            SELECT COUNT(DISTINCT customer_id) AS total 
            FROM `{$this->db->prefix}customer_credit`";
        
        $implode = array();
        
        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
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
