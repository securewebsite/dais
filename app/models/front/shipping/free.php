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

class Free extends Model {
    function getQuote($address) {
        Lang::load('shipping/free');
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "zone_to_geo_zone 
            WHERE geo_zone_id = '" . (int)Config::get('free_geo_zone_id') . "' 
            AND country_id    = '" . (int)$address['country_id'] . "' 
            AND (zone_id      = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );
        
        if (!Config::get('free_geo_zone_id')):
            $status = true;
        elseif ($query->num_rows):
            $status = true;
        else:
            $status = false;
        endif;
        
        if (Cart::getSubTotal() < Config::get('free_total')):
            $status = false;
        endif;
        
        $method_data = array();
        
        if ($status):
            $quote_data = array();
            
            $quote_data['free'] = array(
                'code'  => 'free.free', 
                'title' => Lang::get('lang_text_description'), 
                'cost'  => 0.00, 'tax_class_id' => 0, 
                'text'  => Currency::format(0.00)
            );
            
            $method_data = array(
                'code'       => 'free', 
                'title'      => Lang::get('lang_text_title'), 
                'quote'      => $quote_data, 
                'sort_order' => Config::get('free_sort_order'), 
                'error'      => false
            );
        endif;
        
        return $method_data;
    }
}
