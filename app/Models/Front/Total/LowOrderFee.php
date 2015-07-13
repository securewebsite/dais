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
        if ($this->cart->getSubTotal() && ($this->cart->getSubTotal() < Config::get('loworderfee_total'))):
            Lang::load('total/low_order_fee');
            
            $total_data[] = array(
                'code'       => 'low_order_fee', 
                'title'      => Lang::get('lang_text_low_order_fee'), 
                'text'       => $this->currency->format(Config::get('loworderfee_fee')), 
                'value'      => Config::get('loworderfee_fee'), 
                'sort_order' => Config::get('loworderfee_sort_order')
            );
            
            if (Config::get('loworderfee_tax_class_id')):
                $tax_rates = $this->tax->getRates(Config::get('loworderfee_fee'), Config::get('loworderfee_tax_class_id'));
                
                foreach ($tax_rates as $tax_rate):
                    if (!isset($taxes[$tax_rate['tax_rate_id']])):
                        $taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    else:
                        $taxes[$tax_rate['tax_rate_id']]+= $tax_rate['amount'];
                    endif;
                endforeach;
            endif;
            
            $total += Config::get('loworderfee_fee');
        endif;
    }
}
