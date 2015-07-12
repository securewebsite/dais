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
use Dais\Library\Log as Log;

class PaypalProIframe extends Model {
    public function getMethod($address, $total) {
        Lang::load('payment/paypal_pro_iframe');
        
        $query = $this->db->query("SELECT * FROM {$this->db->prefix}zone_to_geo_zone WHERE geo_zone_id = '" . (int)Config::get('paypal_pro_iframe_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        
        if (Config::get('paypal_pro_iframe_total') > $total) {
            $status = false;
        } elseif (!Config::get('paypal_pro_iframe_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }
        
        $method_data = array();
        
        if ($status) {
            $method_data = array('code' => 'paypal_pro_iframe', 'title' => Lang::get('lang_text_title'), 'sort_order' => Config::get('paypal_pro_iframe_sort_order'));
        }
        
        return $method_data;
    }
    
    public function addOrder($order_data) {
        $this->db->query("INSERT INTO `{$this->db->prefix}paypal_iframe_order` SET `order_id` = '" . (int)$order_data['order_id'] . "', `created` = NOW(), `modified` = NOW(), `capture_status` = '" . $this->db->escape($order_data['capture_status']) . "', `currency_code` = '" . $this->db->escape($order_data['currency_code']) . "', `total` = '" . (double)$order_data['total'] . "', `authorization_id` = '" . $this->db->escape($order_data['authorization_id']) . "'");
        
        return $this->db->getLastId();
    }
    
    public function addTransaction($transaction_data) {
        $this->db->query("INSERT INTO `{$this->db->prefix}paypal_iframe_order_transaction` SET `paypal_iframe_order_id` = '" . (int)$transaction_data['paypal_iframe_order_id'] . "', `transaction_id` = '" . $this->db->escape($transaction_data['transaction_id']) . "', `parent_transaction_id` = '" . $this->db->escape($transaction_data['parent_transaction_id']) . "', `created` = NOW(), `note` = '" . $this->db->escape($transaction_data['note']) . "', `msgsubid` = '" . $this->db->escape($transaction_data['msgsubid']) . "', `receipt_id` = '" . $this->db->escape($transaction_data['receipt_id']) . "', `payment_type` = '" . $this->db->escape($transaction_data['payment_type']) . "', `payment_status` = '" . $this->db->escape($transaction_data['payment_status']) . "', `pending_reason` = '" . $this->db->escape($transaction_data['pending_reason']) . "', `transaction_entity` = '" . $this->db->escape($transaction_data['transaction_entity']) . "', `amount` = '" . (double)$transaction_data['amount'] . "', `debug_data` = '" . $this->db->escape($transaction_data['debug_data']) . "'");
    }
    
    public function log($message) {
        if (Config::get('paypal_pro_iframe_debug')) {
            $log = new Log('paypal_pro_iframe.log');
            $log->write($message);
        }
    }
}
