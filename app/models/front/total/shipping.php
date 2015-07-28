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

class Shipping extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if (Cart::hasShipping() && isset(Session::p()->data['shipping_method'])):
            $total_data[] = array(
                'code'       => 'shipping', 
                'title'      => Session::p()->data['shipping_method']['title'], 
                'text'       => Currency::format(Session::p()->data['shipping_method']['cost']), 
                'value'      => Session::p()->data['shipping_method']['cost'], 
                'sort_order' => Config::get('shipping_sort_order')
            );
            
            if (Session::p()->data['shipping_method']['tax_class_id']):
                $tax_rates = \Tax::getRates(Session::p()->data['shipping_method']['cost'], Session::p()->data['shipping_method']['tax_class_id']);
                
                foreach ($tax_rates as $tax_rate):
                    if (!isset($taxes[$tax_rate['tax_rate_id']])):
                        $taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    else:
                        $taxes[$tax_rate['tax_rate_id']]+= $tax_rate['amount'];
                    endif;
                endforeach;
            endif;
            
            $total += Session::p()->data['shipping_method']['cost'];
        endif;
    }
}
