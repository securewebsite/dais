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

class Reward extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if (isset($this->session->data['reward'])):
            Lang::load('total/reward');
            
            $points = Customer::getRewardPoints();
            
            if ($this->session->data['reward'] <= $points):
                $discount_total = 0;
                
                $points_total = 0;
                
                foreach (Cart::getProducts() as $product):
                    if ($product['points']):
                        $points_total+= $product['points'];
                    endif;
                endforeach;
                
                $points = min($points, $points_total);
                
                foreach (Cart::getProducts() as $product):
                    $discount = 0;
                    
                    if ($product['points']):
                        $discount = $product['total'] * ($this->session->data['reward'] / $points_total);
                        
                        if ($product['tax_class_id']):
                            $tax_rates = Tax::getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);
                            
                            foreach ($tax_rates as $tax_rate):
                                if ($tax_rate['type'] == 'P'):
                                    $taxes[$tax_rate['tax_rate_id']]-= $tax_rate['amount'];
                                endif;
                            endforeach;
                        endif;
                    endif;
                    
                    $discount_total += $discount;
                endforeach;
                
                $total_data[] = array(
                    'code'       => 'reward', 
                    'title'      => sprintf(Lang::get('lang_text_reward'), $this->session->data['reward']), 
                    'text'       => Currency::format(-$discount_total), 
                    'value'      => - $discount_total, 
                    'sort_order' => Config::get('reward_sort_order')
                );
                
                $total -= $discount_total;
            endif;
        endif;
    }
    
    public function confirm($order_info, $order_total) {
        Lang::load('total/reward');
        
        $points = 0;
        $start  = strpos($order_total['title'], '(') + 1;
        $end    = strrpos($order_total['title'], ')');
        
        if ($start && $end):
            $points = substr($order_total['title'], $start, $end - $start);
        endif;
        
        if ($points):
            DB::query("
				INSERT INTO " . DB::prefix() . "customer_reward 
				SET 
                    customer_id = '" . (int)$order_info['customer_id'] . "', 
                    description = '" . DB::escape(sprintf(Lang::get('lang_text_order_id'), (int)$order_info['order_id'])) . "', 
                    points      = '" . (float) - $points . "', 
                    date_added  = NOW()
			");
        endif;
    }
}
