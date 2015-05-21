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

class PaypalProPf extends Model {
    public function getMethod($address, $total) {
        $this->language->load('payment/paypal_pro_pf');
        
        $query = $this->db->query("SELECT * FROM {$this->db->prefix}zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('paypal_pro_pf_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        
        if ($this->config->get('paypal_pro_pf_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('paypal_pro_pf_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }
        
        $method_data = array();
        
        if ($status) {
            $method_data = array('code' => 'paypal_pro_pf', 'title' => $this->language->get('lang_text_title'), 'sort_order' => $this->config->get('paypal_pro_pf_sort_order'));
        }
        
        return $method_data;
    }
}
