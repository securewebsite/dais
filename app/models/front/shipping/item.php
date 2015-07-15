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

class Item extends Model {
    function getQuote($address) {
        $this->language->load('shipping/item');
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}zone_to_geo_zone 
            WHERE geo_zone_id = '" . (int)$this->config->get('item_geo_zone_id') . "' 
            AND country_id    = '" . (int)$address['country_id'] . "' 
            AND (zone_id      = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );
        
        if (!$this->config->get('item_geo_zone_id')):
            $status = true;
        elseif ($query->num_rows):
            $status = true;
        else:
            $status = false;
        endif;
        
        $method_data = array();
        
        if ($status):
            $items = 0;
            
            foreach ($this->cart->getProducts() as $product):
                if ($product['shipping']) $items+= $product['quantity'];
            endforeach;
            
            $quote_data = array();
            
            $quote_data['item'] = array(
                'code'         => 'item.item', 
                'title'        => $this->language->get('lang_text_description'), 
                'cost'         => $this->config->get('item_cost') * $items, 
                'tax_class_id' => $this->config->get('item_tax_class_id'), 
                'text'         => $this->currency->format($this->tax->calculate($this->config->get('item_cost') * $items, $this->config->get('item_tax_class_id'), $this->config->get('config_tax')))
            );
            
            $method_data = array(
                'code'       => 'item', 
                'title'      => $this->language->get('lang_text_title'), 
                'quote'      => $quote_data, 
                'sort_order' => $this->config->get('item_sort_order'), 
                'error'      => false
            );
        endif;
        
        return $method_data;
    }
}
