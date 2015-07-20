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

class Affiliate extends Model {

	public function getSettings() {
		$data = array();

		$query = DB::query("
			SELECT DISTINCT *, 
			(SELECT slug 
				FROM " . DB::prefix() . "affiliate_route 
				WHERE query = 'affiliate_id:" . (int)\Customer::getId() . "') AS slug 
			FROM " . DB::prefix() . "customer 
			WHERE customer_id = '" . (int)\Customer::getId() . "'
		");

		$data['affiliate_status']    = $query->row['affiliate_status'];
		$data['company']             = $query->row['company'];
		$data['website']             = $query->row['website'];
		$data['code']                = $query->row['code'];
		$data['commission']          = $query->row['commission'];
		$data['tax_id']              = $query->row['tax_id'];
		$data['payment_method']      = $query->row['payment_method'];
		$data['cheque']              = $query->row['cheque'];
		$data['paypal']              = $query->row['paypal'];
		$data['bank_name']           = $query->row['bank_name'];
		$data['bank_branch_number']  = $query->row['bank_branch_number'];
		$data['bank_swift_code']     = $query->row['bank_swift_code'];
		$data['bank_account_name']   = $query->row['bank_account_name'];
		$data['bank_account_number'] = $query->row['bank_account_number'];
		$data['slug']                = $query->row['slug'];

		return $data;
	}

	public function editSettings($data = array()) {
		DB::query("
			UPDATE " . DB::prefix() . "customer 
			SET 
				affiliate_status    = '" . (int)$data['affiliate_status'] . "', 
				code                = '" . DB::escape($data['code']) . "', 
				company             = '" . DB::escape($data['company']) . "', 
				website             = '" . DB::escape($data['website']) . "', 
				tax_id              = '" . DB::escape($data['tax_id']) . "',
				payment_method      = '" . DB::escape($data['payment_method']) . "', 
				cheque              = '" . DB::escape($data['cheque']) . "', 
				paypal              = '" . DB::escape($data['paypal']) . "', 
				bank_name           = '" . DB::escape($data['bank_name']) . "', 
				bank_branch_number  = '" . DB::escape($data['bank_branch_number']) . "', 
				bank_swift_code     = '" . DB::escape($data['bank_swift_code']) . "', 
				bank_account_name   = '" . DB::escape($data['bank_account_name']) . "', 
				bank_account_number = '" . DB::escape($data['bank_account_number']) . "' 
			WHERE customer_id = '" . (int)\Customer::getId() . "'"
		);

		DB::query("
            DELETE FROM " . DB::prefix() . "affiliate_route 
            WHERE query = 'affiliate_id:" . (int)\Customer::getId() . "'
        ");
		
		if ($data['slug']):
            DB::query("
				INSERT INTO " . DB::prefix() . "affiliate_route 
				SET 
					route = '" . Theme::getstyle() . "/home', 
					query = 'affiliate_id:" . (int)\Customer::getId() . "', 
					slug  = '" . DB::escape($data['slug']) . "'
			");
        endif;

        $this->cache->delete('default.store.routes');
	}

	public function addAffiliate() {
		DB::query("
			UPDATE " . DB::prefix() . "customer 
			SET 
				is_affiliate     = '1', 
				affiliate_status = '1', 
				code             = '" . DB::escape($code) . "', 
				commission       = '" . (float)Config::get('config_commission') . "' 
			WHERE customer_id = '" . (int)\Customer::getId() . "'
		");

		\Customer::setAffiliate();
		\Customer::setCode($code);

		return true;
	}

	public function getAffiliate($affiliate_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "customer 
			WHERE customer_id = '" . (int)$affiliate_id . "'
		");
        
        return $query->row;
    }

	public function getCommissions($data = array()) {
        $sql = "
			SELECT * 
			FROM " . DB::prefix() . "customer_commission 
			WHERE customer_id = '" . (int)\Customer::getId() . "'";
        
        $sort_data = array(
        	'amount', 
        	'description', 
        	'date_added'
        );
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)):
            $sql.= " ORDER BY {$data['sort']}";
        else:
            $sql.= " ORDER BY date_added";
        endif;
        
        if (isset($data['order']) && ($data['order'] == 'desc')):
            $sql.= " DESC";
        else:
            $sql.= " ASC";
        endif;
        
        if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = 20;
            endif;
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function getTotalCommissions() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_commission 
			WHERE customer_id = '" . (int)\Customer::getId() . "'
		");
        
        return $query->row['total'];
    }
    
    public function getBalance() {
        $query = DB::query("
			SELECT SUM(amount) AS total 
			FROM " . DB::prefix() . "customer_commission 
			WHERE customer_id = '" . (int)\Customer::getId() . "' 
			GROUP BY customer_id
		");
        
        return ($query->num_rows) ? $query->row['total'] : 0;
    }

    public function getAffiliateCommission($customer_id) {
        $query = DB::query("
			SELECT commission 
			FROM " . DB::prefix() . "customer 
			WHERE customer_id = '" . (int)$customer_id . "' 
			AND is_affiliate = '1' 
			AND affiliate_status = '1'
		");
        
        return $query->row['commission'];
    }

    public function generateId() {
    	$code = uniqid();

    	$query = DB::query("
    		SELECT COUNT(customer_id) AS total 
    		FROM " . DB::prefix() . "customer 
    		WHERE code = '" . DB::escape($code) . "'
    	");

    	if ($query->row['total']):
    		return $this->generateId();
    	else:
    		return $code;
    	endif;
    }
}
