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

class Recurring extends Model {
    
    public function getRecurring($id) {
        $query = $this->db->query("
			SELECT 
				`or`.*,
				`o`.`payment_method`,
				`o`.`payment_code`,
				`o`.`currency_code` 
			FROM `{$this->db->prefix}order_recurring` `or` 
			LEFT JOIN `{$this->db->prefix}order` `o` 
			ON `or`.`order_id` = `o`.`order_id` 
			WHERE `or`.`order_recurring_id` = '" . (int)$id . "' 
			AND `o`.`customer_id` = '" . (int)$this->customer->getId() . "' LIMIT 1
		");
        
        if ($query->num_rows):
            return $query->row;
        else:
            return false;
        endif;
    }
    
    public function getRecurringByRef($ref) {
        $query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}order_recurring` 
			WHERE `reference` = '" . $this->db->escape($ref) . "' 
			LIMIT 1
		");
        
        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }
    
    public function getRecurringTransactions($id) {
        
        $recurring = $this->getRecurring($id);
        
        $query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}order_recurring_transaction` 
			WHERE `order_recurring_id` = '" . (int)$id . "'
		");
        
        if ($query->num_rows):
            $transactions = array();
            
            foreach ($query->rows as $transaction):
                $transaction['amount'] = $this->currency->format($transaction['amount'], $recurring['currency_code'], 1);
                $transactions[]        = $transaction;
            endforeach;
            
            return $transactions;
        else:
            return false;
        endif;
    }
    
    public function getAllRecurring($start = 0, $limit = 20) {
        if ($start < 0):
            $start = 0;
        endif;
        
        if ($limit < 1):
            $limit = 1;
        endif;
        
        $query = $this->db->query("
			SELECT 
				`or`.*,
				`o`.`payment_method`,
				`o`.`currency_id`,
				`o`.`currency_value` 
			FROM `{$this->db->prefix}order_recurring` `or` 
			LEFT JOIN `{$this->db->prefix}order` `o` 
				ON `or`.`order_id` = `o`.`order_id` 
			WHERE `o`.`customer_id` = '" . (int)$this->customer->getId() . "' 
			ORDER BY `o`.`order_id` 
			DESC LIMIT " . (int)$start . "," . (int)$limit);
        
        if ($query->num_rows):
            $recurring = array();
            
            foreach ($query->rows as $row):
                $recurring[] = $row;
            endforeach;
            
            return $recurring;
        else:
            return false;
        endif;
    }
    
    public function getTotalRecurring() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM `{$this->db->prefix}order_recurring` `or` 
			LEFT JOIN `{$this->db->prefix}order` `o` 
				ON `or`.`order_id` = `o`.`order_id` 
			WHERE `o`.`customer_id` = '" . (int)$this->customer->getId() . "'
		");
        
        return $query->row['total'];
    }
}
