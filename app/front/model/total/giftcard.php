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

class Giftcard extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if (isset($this->session->data['giftcard'])):
            $this->language->load('total/giftcard');
            
            $this->theme->model('checkout/giftcard');
            
            $giftcard_info = $this->model_checkout_giftcard->getGiftcard($this->session->data['giftcard']);
            
            if ($giftcard_info):
                if ($giftcard_info['amount'] > $total):
                    $amount = $total;
                else:
                    $amount = $giftcard_info['amount'];
                endif;
                
                $total_data[] = array(
                    'code'       => 'giftcard', 
                    'title'      => sprintf($this->language->get('lang_text_giftcard'), $this->session->data['giftcard']), 
                    'text'       => $this->currency->format(-$amount), 
                    'value'      => - $amount, 
                    'sort_order' => $this->config->get('giftcard_sort_order')
                );
                
                $total -= $amount;
            endif;
        endif;
    }
    
    public function confirm($order_info, $order_total) {
        $code  = '';
        $start = strpos($order_total['title'], '(') + 1;
        $end   = strrpos($order_total['title'], ')');
        
        if ($start && $end):
            $code = substr($order_total['title'], $start, $end - $start);
        endif;
        
        $this->theme->model('checkout/giftcard');
        
        $giftcard_info = $this->model_checkout_giftcard->getGiftcard($code);
        
        if ($giftcard_info):
            $this->model_checkout_giftcard->redeem($giftcard_info['giftcard_id'], $order_info['order_id'], $order_total['value']);
        endif;
    }
}
