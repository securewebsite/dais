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

namespace Front\Model\Account;
use Dais\Base\Model;

class Affiliate extends Model {

	public function getSettings() {
		$data = array();

		$query = $this->db->query("
			SELECT DISTINCT *, 
			(SELECT slug 
				FROM {$this->db->prefix}affiliate_route 
				WHERE query = 'affiliate_id:" . (int)$this->customer->getId() . "') AS slug 
			FROM {$this->db->prefix}customer 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'
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
		$this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET 
				affiliate_status    = '" . (int)$data['affiliate_status'] . "', 
				code                = '" . $this->db->escape($data['code']) . "', 
				company             = '" . $this->db->escape($data['company']) . "', 
				website             = '" . $this->db->escape($data['website']) . "', 
				tax_id              = '" . $this->db->escape($data['tax_id']) . "',
				payment_method      = '" . $this->db->escape($data['payment_method']) . "', 
				cheque              = '" . $this->db->escape($data['cheque']) . "', 
				paypal              = '" . $this->db->escape($data['paypal']) . "', 
				bank_name           = '" . $this->db->escape($data['bank_name']) . "', 
				bank_branch_number  = '" . $this->db->escape($data['bank_branch_number']) . "', 
				bank_swift_code     = '" . $this->db->escape($data['bank_swift_code']) . "', 
				bank_account_name   = '" . $this->db->escape($data['bank_account_name']) . "', 
				bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "' 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'"
		);

		$this->db->query("
            DELETE FROM {$this->db->prefix}affiliate_route 
            WHERE query = 'affiliate_id:" . (int)$this->customer->getId() . "'
        ");
		
		if ($data['slug']):
            $this->db->query("
				INSERT INTO {$this->db->prefix}affiliate_route 
				SET 
					route = '" . $this->theme->style . "/home', 
					query = 'affiliate_id:" . (int)$this->customer->getId() . "', 
					slug  = '" . $this->db->escape($data['slug']) . "'
			");
        endif;

        $this->cache->delete('default.store.routes');
	}

	public function addAffiliate() {
		$this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET 
				is_affiliate     = '1', 
				affiliate_status = '1', 
				code             = '" . $this->db->escape($code) . "', 
				commission       = '" . (float)$this->config->get('config_commission') . "' 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'
		");

		$this->customer->setAffiliate();
		$this->customer->setCode($code);

		return true;
	}

	public function getAffiliate($affiliate_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}customer 
			WHERE customer_id = '" . (int)$affiliate_id . "'
		");
        
        return $query->row;
    }

	public function getCommissions($data = array()) {
        $sql = "
			SELECT * 
			FROM {$this->db->prefix}customer_commission 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'";
        
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
        
        if (isset($data['order']) && ($data['order'] == 'DESC')):
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
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getTotalCommissions() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}customer_commission 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'
		");
        
        return $query->row['total'];
    }
    
    public function getBalance() {
        $query = $this->db->query("
			SELECT SUM(amount) AS total 
			FROM {$this->db->prefix}customer_commission 
			WHERE customer_id = '" . (int)$this->customer->getId() . "' 
			GROUP BY customer_id
		");
        
        return ($query->num_rows) ? $query->row['total'] : 0;
    }

    public function getAffiliateCommission($customer_id) {
        $query = $this->db->query("
			SELECT commission 
			FROM {$this->db->prefix}customer 
			WHERE customer_id = '" . (int)$customer_id . "' 
			AND is_affiliate = '1' 
			AND affiliate_status = '1'
		");
        
        return $query->row['commission'];
    }

    public function generateId() {
    	$code = uniqid();

    	$query = $this->db->query("
    		SELECT COUNT(customer_id) AS total 
    		FROM {$this->db->prefix}customer 
    		WHERE code = '" . $this->db->escape($code) . "'
    	");

    	if ($query->row['total']):
    		return $this->generateId();
    	else:
    		return $code;
    	endif;
    }
}
