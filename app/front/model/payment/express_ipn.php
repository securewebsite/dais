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

namespace Front\Model\Payment;
use Dais\Engine\Model;

class ExpressIpn extends Model {
    public function updateStatus($status, $trans_id) {
        $this->db->query("
			UPDATE `{$this->db->prefix}paypal_order_transaction` 
			SET 
				`payment_status` = '" . $status . "' 
			WHERE `transaction_id` = '" . $this->db->escape($trans_id) . "' 
			LIMIT 1");
    }
    
    public function updatePending($reason, $trans_id) {
        $this->db->query("
			UPDATE `{$this->db->prefix}paypal_order_transaction` 
			SET 
				`pending_reason` = '" . $reason . "' 
			WHERE `transaction_id` = '" . $this->db->escape($trans_id) . "' 
			LIMIT 1");
    }
    
    public function processRefund($mc_gross, $amount, $trans_id) {
        if (($mc_gross * -1) == $amount):
            $this->db->query("
				UPDATE `{$this->db->prefix}paypal_order_transaction` 
				SET 
					`payment_status` = 'Refunded' 
				WHERE `transaction_id` = '" . $this->db->escape($trans_id) . "' 
				LIMIT 1");
        else:
            $this->db->query("
				UPDATE `{$this->db->prefix}paypal_order_transaction` 
				SET 
					`payment_status` = 'Partially-Refunded' 
				WHERE `transaction_id` = '" . $this->db->escape($trans_id) . "' 
				LIMIT 1");
        endif;
    }
    
    public function processPayment($recurring_id, $amount, $status) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`amount` = '" . (float)$amount . "', 
				`type` = '1'");
        
        //as there was a payment the recurring is active, ensure it is set to active (may be been suspended before)
        if ($status != 1):
            $this->db->query("
				UPDATE `{$this->db->prefix}order_recurring` 
				SET `status` = 2 
				WHERE `order_recurring_id` = '" . (int)$recurring_id . "'");
        endif;
    }
    
    public function processSuspend($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '6'");
        
        $this->db->query("
			UPDATE `{$this->db->prefix}order_recurring` 
			SET 
				`status` = 3 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
    
    public function suspendMaxFailed($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '7'");
        
        $this->db->query("
			UPDATE `{$this->db->prefix}order_recurring` 
			SET 
				`status` = 3 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
    
    public function paymentFailed($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '4'");
    }
    
    public function outstandingPaymentFailed($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '8'");
    }
    
    public function outstandingPayment($recurring_id, $amount, $status) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`amount` = '" . (float)$amount . "', 
				`type` = '2'");
        
        //as there was a payment the recurring is active, ensure it is set to active (may be been suspended before)
        if ($status != 1):
            $this->db->query("
				UPDATE `{$this->db->prefix}order_recurring` 
				SET 
					`status` = 2 
				WHERE `order_recurring_id` = '" . (int)$recurring_id . "'");
        endif;
    }
    
    public function dateAdded($recurring_id, $status) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '0'");
        
        if ($status != 1):
            $this->db->query("
				UPDATE `{$this->db->prefix}order_recurring` 
				SET 
					`status` = 2 
				WHERE `order_recurring_id` = '" . (int)$recurring_id . "'");
        endif;
    }
    
    public function processCanceled($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '5'");
        
        $this->db->query("
			UPDATE `{$this->db->prefix}order_recurring` 
			SET 
				`status` = 4 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
    
    public function processSkipped($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '3'");
    }
    
    public function processExpired($recurring_id) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '9'");
        
        $this->db->query("
			UPDATE `{$this->db->prefix}order_recurring` 
			SET 
				`status` = 5 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
}
