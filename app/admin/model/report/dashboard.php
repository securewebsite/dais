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

class Dashboard extends Model {
    
    // Sales
    public function getTotalSales($data = array()) {
        $sql = "SELECT SUM(total) AS total FROM `{$this->db->prefix}order` WHERE order_status_id > '0'";
        
        if (!empty($data['filter_date_added'])) {
            $sql.= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
        
        $query = $this->db->query($sql);
        
        return $query->row['total'];
    }
    
    // Customers Online
    public function getTotalCustomersOnline() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `{$this->db->prefix}customer_online`");
        
        return $query->row['total'];
    }
    
    public function getTotalCustomersOnlineByHour() {
        $online_data = array();
        
        $minus_1 = strtotime('-1 hour');
        $time = time();
        
        for ($i = $minus_1; $i < $time; $i = ($i + 60)) {
            $time = (round($i / 60) * 60);
            
            $online_data[$time] = array('time' => $time, 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				DATE_FORMAT(date_added, '%Y-%m-%d %H:%i:00') AS date_added 
			FROM `{$this->db->prefix}customer_online` 
			WHERE date_added > '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "' 
			AND date_added < '" . date('Y-m-d H:i:s') . "' 
			GROUP BY MINUTE(date_added) 
			ORDER BY date_added
		");
        
        foreach ($query->rows as $result) {
            $online_data[strtotime($result['date_added']) ] = array('time' => strtotime($result['date_added']), 'total' => $result['total']);
        }
        
        return $online_data;
    }
    
    // Orders
    public function getTotalOrdersByDay() {
        $order_data = array();
        
        for ($i = 0; $i < 24; $i++) {
            $order_data[$i] = array('hour' => $i, 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				HOUR(date_added) AS hour 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id >= '" . (int)Config::get('config_order_status_id') . "' 
			AND DATE(date_added) = DATE(NOW()) 
			GROUP BY HOUR(date_added) 
			ORDER BY date_added ASC
		");
        
        foreach ($query->rows as $result) {
            $order_data[$result['hour']] = array('hour' => $result['hour'], 'total' => $result['total']);
        }
        
        return $order_data;
    }
    
    public function getTotalOrdersByWeek() {
        $order_data = array();
        
        $date_start = strtotime('-' . date('w') . ' days');
        
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', $date_start + ($i * 86400));
            
            $order_data[date('w', strtotime($date)) ] = array('day' => date('D', strtotime($date)), 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				date_added 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id >= '" . (int)Config::get('config_order_status_id') . "' 
			AND DATE(date_added) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') 
			GROUP BY DAYNAME(date_added)
		");
        
        foreach ($query->rows as $result) {
            $order_data[date('w', strtotime($result['date_added'])) ] = array('day' => date('D', strtotime($result['date_added'])), 'total' => $result['total']);
        }
        
        return $order_data;
    }
    
    public function getTotalOrdersByMonth() {
        $order_data = array();
        
        $date_t = date('t');
        
        for ($i = 1; $i <= $date_t; $i++) {
            $date = date('Y') . '-' . date('m') . '-' . $i;
            
            $order_data[date('j', strtotime($date)) ] = array('day' => date('d', strtotime($date)), 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				date_added 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id >= '" . (int)Config::get('config_order_status_id') . "' 
			AND DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') . "' 
			GROUP BY DATE(date_added)
		");
        
        foreach ($query->rows as $result) {
            $order_data[date('j', strtotime($result['date_added'])) ] = array('day' => date('d', strtotime($result['date_added'])), 'total' => $result['total']);
        }
        
        return $order_data;
    }
    
    public function getTotalOrdersByYear() {
        $order_data = array();
        
        for ($i = 1; $i <= 12; $i++) {
            $order_data[$i] = array('month' => date('M', mktime(0, 0, 0, $i)), 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				date_added 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id >= '" . (int)Config::get('config_order_status_id') . "' 
			AND YEAR(date_added) = YEAR(NOW()) 
			GROUP BY MONTH(date_added)
		");
        
        foreach ($query->rows as $result) {
            $order_data[date('n', strtotime($result['date_added'])) ] = array('month' => date('M', strtotime($result['date_added'])), 'total' => $result['total']);
        }
        
        return $order_data;
    }
    
    // Customers
    public function getTotalCustomersByDay() {
        $customer_data = array();
        
        for ($i = 0; $i < 24; $i++) {
            $customer_data[$i] = array('hour' => $i, 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				HOUR(date_added) AS hour 
			FROM `{$this->db->prefix}customer` 
			WHERE DATE(date_added) = DATE(NOW()) 
			GROUP BY HOUR(date_added) 
			ORDER BY date_added ASC
		");
        
        foreach ($query->rows as $result) {
            $customer_data[$result['hour']] = array('hour' => $result['hour'], 'total' => $result['total']);
        }
        
        return $customer_data;
    }
    
    public function getTotalCustomersByWeek() {
        $customer_data = array();
        
        $date_start = strtotime('-' . date('w') . ' days');
        
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', $date_start + ($i * 86400));
            
            $customer_data[date('w', strtotime($date)) ] = array('day' => date('D', strtotime($date)), 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				date_added 
			FROM `{$this->db->prefix}customer` 
			WHERE DATE(date_added) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') 
			GROUP BY DAYNAME(date_added)
		");
        
        foreach ($query->rows as $result) {
            $customer_data[date('w', strtotime($result['date_added'])) ] = array('day' => date('D', strtotime($result['date_added'])), 'total' => $result['total']);
        }
        
        return $customer_data;
    }
    
    public function getTotalCustomersByMonth() {
        $customer_data = array();
        
        $date_t = date('t');
        
        for ($i = 1; $i <= $date_t; $i++) {
            $date = date('Y') . '-' . date('m') . '-' . $i;
            
            $customer_data[date('j', strtotime($date)) ] = array('day' => date('d', strtotime($date)), 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				date_added 
			FROM `{$this->db->prefix}customer` 
			WHERE DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') . "' 
			GROUP BY DATE(date_added)
		");
        
        foreach ($query->rows as $result) {
            $customer_data[date('j', strtotime($result['date_added'])) ] = array('day' => date('d', strtotime($result['date_added'])), 'total' => $result['total']);
        }
        
        return $customer_data;
    }
    
    public function getTotalCustomersByYear() {
        $customer_data = array();
        
        for ($i = 1; $i <= 12; $i++) {
            $customer_data[$i] = array('month' => date('M', mktime(0, 0, 0, $i)), 'total' => 0);
        }
        
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total, 
				date_added 
			FROM `{$this->db->prefix}customer` 
			WHERE YEAR(date_added) = YEAR(NOW()) 
			GROUP BY MONTH(date_added)
		");
        
        foreach ($query->rows as $result) {
            $customer_data[date('n', strtotime($result['date_added'])) ] = array('month' => date('M', strtotime($result['date_added'])), 'total' => $result['total']);
        }
        
        return $customer_data;
    }
    
    public function getActivities() {
        $query = $this->db->query("
			SELECT 
				a.key, 
				a.data, 
				a.date_added 
			FROM (
				(SELECT CONCAT('customer_', ca.key) AS `key`, 
				ca.data, 
				ca.date_added 
				FROM `{$this->db->prefix}customer_activity` ca) 
			UNION (
				SELECT CONCAT('affiliate_', aa.key) AS `key`, 
				aa.data, 
				aa.date_added 
			FROM `{$this->db->prefix}affiliate_activity` aa)) a 
			ORDER BY a.date_added DESC LIMIT 0,5
		");
        
        return $query->rows;
    }
    
    public function setLastAccess($user_id) {
        $this->db->query("
			UPDATE {$db->prefix}user 
			SET last_access = NOW() 
			WHERE user_id = '" . (int)$user_id . "'
		");
    }
}
