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

class Subtotal extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        $this->language->load('total/subtotal');
        
        $sub_total = $this->cart->getSubTotal();

        if (isset($this->session->data['giftcards']) && $this->session->data['giftcards']):
            foreach ($this->session->data['giftcards'] as $giftcard):
                $sub_total+= $giftcard['amount'];
            endforeach;
        endif;
        
        $total_data[] = array(
            'code'       => 'subtotal', 
            'title'      => $this->language->get('lang_text_subtotal'), 
            'text'       => $this->currency->format($sub_total), 
            'value'      => $sub_total, 
            'sort_order' => $this->config->get('subtotal_sort_order')
        );
        
        $total += $sub_total;
    }
}
