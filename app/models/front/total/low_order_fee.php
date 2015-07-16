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

namespace App\Models\Front\Total;
use App\Models\Model;

class LowOrderFee extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if (Cart::getSubTotal() && (Cart::getSubTotal() < Config::get('low_order_fee_total'))):
            Lang::load('total/low_order_fee');
            
            $total_data[] = array(
                'code'       => 'low_order_fee', 
                'title'      => Lang::get('lang_text_low_order_fee'), 
                'text'       => Currency::format(Config::get('low_order_fee_fee')), 
                'value'      => Config::get('low_order_fee_fee'), 
                'sort_order' => Config::get('low_order_fee_sort_order')
            );
            
            if (Config::get('low_order_fee_tax_class_id')):
                $tax_rates = Tax::getRates(Config::get('low_order_fee_fee'), Config::get('low_order_fee_tax_class_id'));
                
                foreach ($tax_rates as $tax_rate):
                    if (!isset($taxes[$tax_rate['tax_rate_id']])):
                        $taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    else:
                        $taxes[$tax_rate['tax_rate_id']]+= $tax_rate['amount'];
                    endif;
                endforeach;
            endif;
            
            $total += Config::get('low_order_fee_fee');
        endif;
    }
}
