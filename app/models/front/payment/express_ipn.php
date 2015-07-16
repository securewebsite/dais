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

namespace App\Models\Front\Payment;
use App\Models\Model;

class ExpressIpn extends Model {
    public function updateStatus($status, $trans_id) {
        DB::query("
			UPDATE `" . DB::prefix() . "paypal_order_transaction` 
			SET 
				`payment_status` = '" . $status . "' 
			WHERE `transaction_id` = '" . DB::escape($trans_id) . "' 
			LIMIT 1");
    }
    
    public function updatePending($reason, $trans_id) {
        DB::query("
			UPDATE `" . DB::prefix() . "paypal_order_transaction` 
			SET 
				`pending_reason` = '" . $reason . "' 
			WHERE `transaction_id` = '" . DB::escape($trans_id) . "' 
			LIMIT 1");
    }
    
    public function processRefund($mc_gross, $amount, $trans_id) {
        if (($mc_gross * -1) == $amount):
            DB::query("
				UPDATE `" . DB::prefix() . "paypal_order_transaction` 
				SET 
					`payment_status` = 'Refunded' 
				WHERE `transaction_id` = '" . DB::escape($trans_id) . "' 
				LIMIT 1");
        else:
            DB::query("
				UPDATE `" . DB::prefix() . "paypal_order_transaction` 
				SET 
					`payment_status` = 'Partially-Refunded' 
				WHERE `transaction_id` = '" . DB::escape($trans_id) . "' 
				LIMIT 1");
        endif;
    }
    
    public function processPayment($recurring_id, $amount, $status) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`amount` = '" . (float)$amount . "', 
				`type` = '1'");
        
        //as there was a payment the recurring is active, ensure it is set to active (may be been suspended before)
        if ($status != 1):
            DB::query("
				UPDATE `" . DB::prefix() . "order_recurring` 
				SET `status` = 2 
				WHERE `order_recurring_id` = '" . (int)$recurring_id . "'");
        endif;
    }
    
    public function processSuspend($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '6'");
        
        DB::query("
			UPDATE `" . DB::prefix() . "order_recurring` 
			SET 
				`status` = 3 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
    
    public function suspendMaxFailed($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '7'");
        
        DB::query("
			UPDATE `" . DB::prefix() . "order_recurring` 
			SET 
				`status` = 3 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
    
    public function paymentFailed($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '4'");
    }
    
    public function outstandingPaymentFailed($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '8'");
    }
    
    public function outstandingPayment($recurring_id, $amount, $status) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`amount` = '" . (float)$amount . "', 
				`type` = '2'");
        
        //as there was a payment the recurring is active, ensure it is set to active (may be been suspended before)
        if ($status != 1):
            DB::query("
				UPDATE `" . DB::prefix() . "order_recurring` 
				SET 
					`status` = 2 
				WHERE `order_recurring_id` = '" . (int)$recurring_id . "'");
        endif;
    }
    
    public function dateAdded($recurring_id, $status) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '0'");
        
        if ($status != 1):
            DB::query("
				UPDATE `" . DB::prefix() . "order_recurring` 
				SET 
					`status` = 2 
				WHERE `order_recurring_id` = '" . (int)$recurring_id . "'");
        endif;
    }
    
    public function processCanceled($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '5'");
        
        DB::query("
			UPDATE `" . DB::prefix() . "order_recurring` 
			SET 
				`status` = 4 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
    
    public function processSkipped($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '3'");
    }
    
    public function processExpired($recurring_id) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring_transaction` 
			SET 
				`order_recurring_id` = '" . (int)$recurring_id . "', 
				`date_added` = NOW(), 
				`type` = '9'");
        
        DB::query("
			UPDATE `" . DB::prefix() . "order_recurring` 
			SET 
				`status` = 5 
			WHERE `order_recurring_id` = '" . (int)$recurring_id . "' 
			LIMIT 1");
    }
}
