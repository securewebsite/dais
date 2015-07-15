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

namespace App\Models\Front\Shipping;
use App\Models\Model;

class Flat extends Model {
    function getQuote($address) {
        $this->language->load('shipping/flat');
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}zone_to_geo_zone 
            WHERE geo_zone_id = '" . (int)$this->config->get('flat_geo_zone_id') . "' 
            AND country_id    = '" . (int)$address['country_id'] . "' 
            AND (zone_id      = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );
        
        if (!$this->config->get('flat_geo_zone_id')):
            $status = true;
        elseif ($query->num_rows):
            $status = true;
        else:
            $status = false;
        endif;
        
        $method_data = array();
        
        if ($status):
            $quote_data = array();
            
            $quote_data['flat'] = array(
                'code'         => 'flat.flat', 
                'title'        => $this->language->get('lang_text_description'), 
                'cost'         => $this->config->get('flat_cost'), 
                'tax_class_id' => $this->config->get('flat_tax_class_id'), 
                'text'         => $this->currency->format($this->tax->calculate($this->config->get('flat_cost'), $this->config->get('flat_tax_class_id'), $this->config->get('config_tax')))
            );
            
            $method_data = array(
                'code' => 'flat', 
                'title' => $this->language->get('lang_text_title'), 
                'quote' => $quote_data, 
                'sort_order' => $this->config->get('flat_sort_order'), 
                'error' => false
            );
        endif;
        
        return $method_data;
    }
}
