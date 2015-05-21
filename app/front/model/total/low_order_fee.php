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

namespace Front\Model\Total;
use Dais\Engine\Model;

class LowOrderFee extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if ($this->cart->getSubTotal() && ($this->cart->getSubTotal() < $this->config->get('low_order_fee_total'))):
            $this->language->load('total/low_order_fee');
            
            $total_data[] = array(
                'code'       => 'low_order_fee', 
                'title'      => $this->language->get('lang_text_low_order_fee'), 
                'text'       => $this->currency->format($this->config->get('low_order_fee_fee')), 
                'value'      => $this->config->get('low_order_fee_fee'), 
                'sort_order' => $this->config->get('low_order_fee_sort_order')
            );
            
            if ($this->config->get('low_order_fee_tax_class_id')):
                $tax_rates = $this->tax->getRates($this->config->get('low_order_fee_fee'), $this->config->get('low_order_fee_tax_class_id'));
                
                foreach ($tax_rates as $tax_rate):
                    if (!isset($taxes[$tax_rate['tax_rate_id']])):
                        $taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    else:
                        $taxes[$tax_rate['tax_rate_id']]+= $tax_rate['amount'];
                    endif;
                endforeach;
            endif;
            
            $total += $this->config->get('low_order_fee_fee');
        endif;
    }
}
