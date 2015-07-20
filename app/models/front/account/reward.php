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

namespace App\Models\Front\Account;
use App\Models\Model;

class Reward extends Model {
    public function getRewards($data = array()) {
        $sql = "
			SELECT * 
			FROM `" . DB::prefix() . "customer_reward` 
			WHERE customer_id = '" . (int)\Customer::getId() . "'
		";
        
        $sort_data = array('points', 'description', 'date_added');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY date_added";
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
    }
    
    public function getTotalRewards() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM `" . DB::prefix() . "customer_reward` 
			WHERE customer_id = '" . (int)\Customer::getId() . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalPoints() {
        $query = DB::query("
			SELECT SUM(points) AS total 
			FROM `" . DB::prefix() . "customer_reward` 
			WHERE customer_id = '" . (int)\Customer::getId() . "' GROUP BY customer_id
		");
        
        if ($query->num_rows) {
            return $query->row['total'];
        } else {
            return 0;
        }
    }
}
