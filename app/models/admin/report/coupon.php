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

namespace App\Models\Admin\Report;

use App\Models\Model;

class Coupon extends Model {
    
    public function getCoupons($data = array()) {
        $sql = "SELECT ch.coupon_id, c.name, c.code, COUNT(DISTINCT ch.order_id) AS `orders`, SUM(ch.amount) AS total FROM `" . DB::prefix() . "coupon_history` ch LEFT JOIN `" . DB::prefix() . "coupon` c ON (ch.coupon_id = c.coupon_id)";
        
        $implode = array();
        
        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(ch.date_added) >= '" . DB::escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(ch.date_added) <= '" . DB::escape($data['filter_date_end']) . "'";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        }
        
        $sql.= " GROUP BY ch.coupon_id ORDER BY total DESC";
        
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
    
    public function getTotalCoupons($data = array()) {
        $sql = "SELECT COUNT(DISTINCT coupon_id) AS total FROM `" . DB::prefix() . "coupon_history`";
        
        $implode = array();
        
        if (!empty($data['filter_date_start'])) {
            $implode[] = "DATE(date_added) >= '" . DB::escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $implode[] = "DATE(date_added) <= '" . DB::escape($data['filter_date_end']) . "'";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        }
        
        $query = DB::query($sql);
        
        return $query->row['total'];
    }
}
