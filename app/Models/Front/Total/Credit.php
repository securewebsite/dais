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

class Credit extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if (Config::get('credit_status')):
            Lang::load('total/credit');
            
            $balance = 0;
            
            if ($this->customer->isLogged()):
                $balance = $this->customer->getBalance();
            endif;
            
            if ((float)$balance):
                if ($balance > $total):
                    $credit = $total;
                else:
                    $credit = $balance;
                endif;
                
                if ($credit > 0):
                    $total_data[] = array(
                        'code'       => 'credit', 
                        'title'      => Lang::get('lang_text_credit'), 
                        'text'       => $this->currency->format(-$credit), 
                        'value'      => - $credit, 
                        'sort_order' => Config::get('credit_sort_order'));
                    
                    $total-= $credit;
                endif;
            endif;
        endif;
    }
    
    public function confirm($order_info, $order_total) {
        Lang::load('total/credit');
        
        if ($order_info['customer_id']):
            $this->db->query("
				INSERT INTO {$this->db->prefix}customer_credit 
				SET 
                    customer_id = '" . (int)$order_info['customer_id'] . "', 
                    order_id    = '" . (int)$order_info['order_id'] . "', 
                    description = '" . $this->db->escape(sprintf(Lang::get('lang_text_order_id'), (int)$order_info['order_id'])) . "', 
                    amount      = '" . (float)$order_total['value'] . "', 
                    date_added  = NOW()
			");
        endif;
    }
}
