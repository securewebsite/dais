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

class TwoCheckout extends Model {
    public function getMethod($address, $total) {
        Lang::load('payment/two_checkout');
        
        $query = $this->db->query("SELECT * FROM {$this->db->prefix}zone_to_geo_zone WHERE geo_zone_id = '" . (int)Config::get('twocheckout_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        
        if (Config::get('twocheckout_total') > 0 && Config::get('twocheckout_total') > $total) {
            $status = false;
        } elseif (!Config::get('twocheckout_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }
        
        $method_data = array();
        
        if ($status) {
            $method_data = array('code' => 'two_checkout', 'title' => Lang::get('lang_text_title'), 'sort_order' => Config::get('twocheckout_sort_order'));
        }
        
        return $method_data;
    }
}
