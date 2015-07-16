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

class PayflowIframe extends Model {
    public function getMethod($address, $total) {
        Lang::load('payment/payflow_iframe');
        
        $query = DB::query("SELECT * FROM " . DB::prefix() . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)Config::get('payflow_iframe_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        
        if (Config::get('payflow_iframe_total') > $total) {
            $status = false;
        } elseif (!Config::get('payflow_iframe_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }
        
        $method_data = array();
        
        if ($status) {
            $method_data = array('code' => 'payflow_iframe', 'title' => Lang::get('lang_text_title'), 'sort_order' => Config::get('payflow_iframe_sort_order'));
        }
        
        return $method_data;
    }
    
    public function getOrderId($secure_token_id) {
        $result = DB::query("SELECT `order_id` FROM `" . DB::prefix() . "paypal_payflow_iframe_order` WHERE `secure_token_id` = '" . DB::escape($secure_token_id) . "'")->row;
        
        if ($result) {
            $order_id = $result['order_id'];
        } else {
            $order_id = false;
        }
        
        return $order_id;
    }
    
    public function addOrder($order_id, $secure_token_id) {
        DB::query("INSERT INTO `" . DB::prefix() . "paypal_payflow_iframe_order` SET `order_id` = '" . (int)$order_id . "', `secure_token_id` = '" . DB::escape($secure_token_id) . "'");
    }
    
    public function updateOrder($data) {
        DB::query("
			UPDATE `" . DB::prefix() . "paypal_payflow_iframe_order`
			SET `transaction_reference` = '" . DB::escape($data['transaction_reference']) . "',
				`transaction_type` = '" . DB::escape($data['transaction_type']) . "',
				`complete` = " . (int)$data['complete'] . "
			WHERE `secure_token_id` = '" . DB::escape($data['secure_token_id']) . "'
		");
    }
    
    public function call($data) {
        $default_parameters = array('USER' => Config::get('payflow_iframe_user'), 'VENDOR' => Config::get('payflow_iframe_vendor'), 'PWD' => Config::get('payflow_iframe_password'), 'PARTNER' => Config::get('payflow_iframe_partner'), 'BUTTONSOURCE' => 'Dais_Cart_PFP',);
        
        $call_parameters = array_merge($data, $default_parameters);
        
        if (Config::get('payflow_iframe_test')) {
            $url = 'https://pilot-payflowpro.paypal.com';
        } else {
            $url = 'https://payflowpro.paypal.com';
        }
        
        $query_params = array();
        
        foreach ($call_parameters as $key => $value) {
            $query_params[] = $key . '=' . utf8_decode($value);
        }
        
        $this->log('Call data: ' . implode('&', $query_params));
        
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $query_params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($curl);
        
        $this->log('Response data: ' . $response);
        
        $response_params = array();
        parse_str($response, $response_params);
        
        return $response_params;
    }
    
    public function addTransaction($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "paypal_payflow_iframe_order_transaction
			SET order_id = " . (int)$data['order_id'] . ",
				transaction_reference = '" . DB::escape($data['transaction_reference']) . "',
				transaction_type = '" . DB::escape($data['type']) . "',
				`time` = NOW(),
				`amount` = '" . DB::escape($data['amount']) . "'
		");
    }
    
    public function log($message) {
        if (Config::get('payflow_iframe_debug')) {
            $log = new Log('payflow-iframe.log');
            $log->write($message);
        }
    }
}
