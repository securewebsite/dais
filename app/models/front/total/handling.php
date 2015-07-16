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

class Handling extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if ((Cart::getSubTotal() < Config::get('handling_total')) && (Cart::getSubTotal() > 0)) {
            Lang::load('total/handling');
            
            $total_data[] = array('code' => 'handling', 'title' => Lang::get('lang_text_handling'), 'text' => Currency::format(Config::get('handling_fee')), 'value' => Config::get('handling_fee'), 'sort_order' => Config::get('handling_sort_order'));
            
            if (Config::get('handling_tax_class_id')) {
                $tax_rates = Tax::getRates(Config::get('handling_fee'), Config::get('handling_tax_class_id'));
                
                foreach ($tax_rates as $tax_rate) {
                    if (!isset($taxes[$tax_rate['tax_rate_id']])) {
                        $taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    } else {
                        $taxes[$tax_rate['tax_rate_id']]+= $tax_rate['amount'];
                    }
                }
            }
            
            $total+= Config::get('handling_fee');
        }
    }
}
