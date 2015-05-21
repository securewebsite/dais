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

class SubTotal extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        $this->language->load('total/sub_total');
        
        $sub_total = $this->cart->getSubTotal();

        if (isset($this->session->data['gift_cards']) && $this->session->data['gift_cards']):
            foreach ($this->session->data['gift_cards'] as $gift_card):
                $sub_total+= $gift_card['amount'];
            endforeach;
        endif;
        
        $total_data[] = array(
            'code'       => 'sub_total', 
            'title'      => $this->language->get('lang_text_sub_total'), 
            'text'       => $this->currency->format($sub_total), 
            'value'      => $sub_total, 
            'sort_order' => $this->config->get('sub_total_sort_order')
        );
        
        $total += $sub_total;
    }
}
