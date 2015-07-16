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

class Download extends Model {
    public function getDownload($order_download_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "order_download od 
			LEFT JOIN `" . DB::prefix() . "order` o 
				ON (od.order_id = o.order_id) 
			WHERE o.customer_id = '" . (int)\Customer::getId() . "' 
			AND o.order_status_id > '0' 
			AND o.order_status_id = '" . (int)Config::get('config_complete_status_id') . "' 
			AND od.order_download_id = '" . (int)$order_download_id . "' 
			AND od.remaining > 0
		");
        
        return $query->row;
    }
    
    public function getDownloads($start = 0, $limit = 20) {
        if ($start < 0) {
            $start = 0;
        }
        
        if ($limit < 1) {
            $limit = 20;
        }
        
        $query = DB::query("
			SELECT 
				o.order_id, 
				o.date_added, 
				od.order_download_id, 
				od.name, 
				od.filename, 
				od.remaining 
			FROM " . DB::prefix() . "order_download od 
			LEFT JOIN `" . DB::prefix() . "order` o 
				ON (od.order_id = o.order_id) 
			WHERE o.customer_id = '" . (int)\Customer::getId() . "' 
			AND o.order_status_id > '0' 
			AND o.order_status_id = '" . (int)Config::get('config_complete_status_id') . "' 
			AND od.remaining > 0 
			ORDER BY o.date_added 
			DESC LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function updateRemaining($order_download_id) {
        DB::query("
			UPDATE " . DB::prefix() . "order_download 
			SET 
				remaining = (remaining - 1) 
			WHERE order_download_id = '" . (int)$order_download_id . "'
		");
    }
    
    public function getTotalDownloads() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "order_download od 
			LEFT JOIN `" . DB::prefix() . "order` o 
			ON (od.order_id = o.order_id) 
			WHERE o.customer_id = '" . (int)\Customer::getId() . "' 
			AND o.order_status_id > '0' 
			AND o.order_status_id = '" . (int)Config::get('config_complete_status_id') . "' 
			AND od.remaining > 0
		");
        
        return $query->row['total'];
    }
}
