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

class Weight extends Model {
    public function getQuote($address) {
        Lang::load('shipping/weight');
        
        $quote_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "geo_zone ORDER BY name"
        );
        
        foreach ($query->rows as $result):
            if (Config::get('weight_' . $result['geo_zone_id'] . '_status')):
                $query = DB::query("
                    SELECT * 
                    FROM " . DB::prefix() . "zone_to_geo_zone 
                    WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' 
                    AND country_id    = '" . (int)$address['country_id'] . "' 
                    AND (zone_id      = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
                );
                
                if ($query->num_rows):
                    $status = true;
                else:
                    $status = false;
                endif;
            else:
                $status = false;
            endif;
            
            if ($status):
                $cost   = '';
                $weight = Cart::getWeight();
                $rates  = explode(',', Config::get('weight_' . $result['geo_zone_id'] . '_rate'));
                
                foreach ($rates as $rate):
                    $data = explode(':', $rate);
                    
                    if ($data[0] >= $weight):
                        if (isset($data[1])):
                            $cost = $data[1];
                        endif;
                        break;
                    endif;
                endforeach;
                
                if ((string)$cost != ''):
                    $quote_data['weight_' . $result['geo_zone_id']] = array(
                        'code'         => 'weight.weight_' . $result['geo_zone_id'], 
                        'title'        => $result['name'] . '  (' . Lang::get('lang_text_weight') . ' ' . Weight::format($weight, Config::get('config_weight_class_id')) . ')', 
                        'cost'         => $cost, 
                        'tax_class_id' => Config::get('weight_tax_class_id'), 
                        'text'         => Currency::format(Tax::calculate($cost, Config::get('weight_tax_class_id'), Config::get('config_tax')))
                    );
                endif;
            endif;
        endforeach;
        
        $method_data = array();
        
        if ($quote_data):
            $method_data = array(
                'code'       => 'weight', 
                'title'      => Lang::get('lang_text_title'), 
                'quote'      => $quote_data, 
                'sort_order' => Config::get('weight_sort_order'), 
                'error'      => false
            );
        endif;
        
        return $method_data;
    }
}
