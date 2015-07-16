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

class Online extends Model {
    
    public function getCustomersOnline($data = array()) {
        $sql = "SELECT co.ip, co.customer_id, co.url, co.referer, co.date_added FROM " . DB::prefix() . "customer_online co LEFT JOIN " . DB::prefix() . "customer c ON (co.customer_id = c.customer_id)";
        
        $implode = array();
        
        if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
            $implode[] = "co.ip LIKE '" . DB::escape($data['filter_ip']) . "'";
        }
        
        if (isset($data['filter_customer']) && !is_null($data['filter_customer'])) {
            $implode[] = "co.customer_id > 0 AND CONCAT(c.firstname, ' ', c.lastname) LIKE '" . DB::escape($data['filter_customer']) . "'";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        }
        
        $sql.= " ORDER BY co.date_added DESC";
        
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
    
    public function getTotalCustomersOnline($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB::prefix() . "customer_online` co LEFT JOIN " . DB::prefix() . "customer c ON (co.customer_id = c.customer_id)";
        
        $implode = array();
        
        if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
            $implode[] = "co.ip LIKE '" . DB::escape($data['filter_ip']) . "'";
        }
        
        if (isset($data['filter_customer']) && !is_null($data['filter_customer'])) {
            $implode[] = "co.customer_id > 0 AND CONCAT(c.firstname, ' ', c.lastname) LIKE '" . DB::escape($data['filter_customer']) . "'";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        }
        
        $query = DB::query($sql);
        
        return $query->row['total'];
    }
}
