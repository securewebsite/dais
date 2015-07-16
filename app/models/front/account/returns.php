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

class Returns extends Model {
    public function addReturn($data) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "return` 
			SET 
				order_id         = '" . (int)$data['order_id'] . "', 
				customer_id      = '" . (int)\Customer::getId() . "', 
				firstname        = '" . DB::escape($data['firstname']) . "', 
				lastname         = '" . DB::escape($data['lastname']) . "', 
				email            = '" . DB::escape($data['email']) . "', 
				telephone        = '" . DB::escape($data['telephone']) . "', 
				product          = '" . DB::escape($data['product']) . "', 
				model            = '" . DB::escape($data['model']) . "', 
				quantity         = '" . (int)$data['quantity'] . "', 
				opened           = '" . (int)$data['opened'] . "', 
				return_reason_id = '" . (int)$data['return_reason_id'] . "', 
				return_status_id = '" . (int)Config::get('config_return_status_id') . "', 
				comment          = '" . DB::escape($data['comment']) . "', 
				date_ordered     = '" . DB::escape($data['date_ordered']) . "', 
				date_added       = NOW(), 
				date_modified = NOW()
		");
        
        $return_id = DB::getLastId();
        
        Theme::trigger('front_return_add', array('return_id' => $return_id));
    }
    
    public function getReturn($return_id) {
        $query = DB::query("
			SELECT 
				r.return_id, 
				r.order_id, 
				r.firstname, 
				r.lastname, 
				r.email, 
				r.telephone, 
				r.product, 
				r.model, 
				r.quantity, 
				r.opened, 
				(SELECT 
					rr.name 
					FROM " . DB::prefix() . "return_reason rr 
					WHERE rr.return_reason_id = r.return_reason_id 
					AND rr.language_id = '" . (int)Config::get('config_language_id') . "'
					) AS reason, 
				(SELECT 
					ra.name 
					FROM " . DB::prefix() . "return_action ra 
					WHERE ra.return_action_id = r.return_action_id 
					AND ra.language_id = '" . (int)Config::get('config_language_id') . "'
					) AS action, 
				(SELECT 
					rs.name 
					FROM " . DB::prefix() . "return_status rs 
					WHERE rs.return_status_id = r.return_status_id 
					AND rs.language_id = '" . (int)Config::get('config_language_id') . "'
					) AS status, 
				r.comment, 
				r.date_ordered, 
				r.date_added, 
				r.date_modified 
			FROM `" . DB::prefix() . "return` r 
			WHERE return_id = '" . (int)$return_id . "' 
			AND customer_id = '" . \Customer::getId() . "'
		");
        
        return $query->row;
    }
    
    public function getReturns($start = 0, $limit = 20) {
        if ($start < 0) {
            $start = 0;
        }
        
        if ($limit < 1) {
            $limit = 20;
        }
        
        $query = DB::query("
			SELECT 
				r.return_id, 
				r.order_id, 
				r.firstname, 
				r.lastname, 
				rs.name as status, 
				r.date_added 
			FROM `" . DB::prefix() . "return` r 
			LEFT JOIN " . DB::prefix() . "return_status rs 
				ON (r.return_status_id = rs.return_status_id) 
			WHERE r.customer_id = '" . \Customer::getId() . "' 
			AND rs.language_id = '" . (int)Config::get('config_language_id') . "' 
			ORDER BY r.return_id 
			DESC LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalReturns() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM `" . DB::prefix() . "return` 
			WHERE customer_id = '" . \Customer::getId() . "'
		");
        
        return $query->row['total'];
    }
    
    public function getReturnHistories($return_id) {
        $query = DB::query("
			SELECT 
				rh.date_added, 
				rs.name AS status, 
				rh.comment, 
				rh.notify 
			FROM " . DB::prefix() . "return_history rh 
			LEFT JOIN " . DB::prefix() . "return_status rs 
				ON rh.return_status_id = rs.return_status_id 
			WHERE rh.return_id = '" . (int)$return_id . "' 
			AND rs.language_id = '" . (int)Config::get('config_language_id') . "' 
			ORDER BY rh.date_added ASC
		");
        
        return $query->rows;
    }
}
