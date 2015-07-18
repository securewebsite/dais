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

class Coupon extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        if (isset($this->session->data['coupon'])):
            Lang::load('total/coupon');
            
            Theme::model('checkout/coupon');
            
            $coupon_info = CheckoutCoupon::getCoupon($this->session->data['coupon']);
            
            if ($coupon_info):
                $discount_total = 0;
                
                if (!$coupon_info['product']):
                    $sub_total = Cart::getSubTotal();
                else:
                    $sub_total = 0;
                    
                    foreach (Cart::getProducts() as $product):
                        if (in_array($product['product_id'], $coupon_info['product'])):
                            $sub_total+= $product['total'];
                        endif;
                    endforeach;
                endif;
                
                if ($coupon_info['type'] == 'F'):
                    $coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
                endif;
                
                foreach (Cart::getProducts() as $product):
                    $discount = 0;
                    
                    if (!$coupon_info['product']):
                        $status = true;
                    else:
                        if (in_array($product['product_id'], $coupon_info['product'])):
                            $status = true;
                        else:
                            $status = false;
                        endif;
                    endif;
                    
                    if ($status):
                        if ($coupon_info['type'] == 'F'):
                            $discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
                        elseif ($coupon_info['type'] == 'P'):
                            $discount = $product['total'] / 100 * $coupon_info['discount'];
                        endif;
                        
                        if ($product['tax_class_id']):
                            $tax_rates = \Tax::getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);
                            
                            foreach ($tax_rates as $tax_rate):
                                if ($tax_rate['type'] == 'P'):
                                    $taxes[$tax_rate['tax_rate_id']]-= $tax_rate['amount'];
                                endif;
                            endforeach;
                        endif;
                    endif;
                    
                    $discount_total+= $discount;
                endforeach;
                
                if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])):
                    if (!empty($this->session->data['shipping_method']['tax_class_id'])):
                        $tax_rates = \Tax::getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
                        
                        foreach ($tax_rates as $tax_rate):
                            if ($tax_rate['type'] == 'P'):
                                $taxes[$tax_rate['tax_rate_id']]-= $tax_rate['amount'];
                            endif;
                        endforeach;
                    endif;
                    
                    $discount_total+= $this->session->data['shipping_method']['cost'];
                endif;
                
                $total_data[] = array(
                    'code'       => 'coupon', 
                    'title'      => sprintf(Lang::get('lang_text_coupon'), $this->session->data['coupon']), 
                    'text'       => Currency::format(-$discount_total), 
                    'value'      => - $discount_total, 
                    'sort_order' => Config::get('coupon_sort_order')
                );
                
                $total-= $discount_total;
            endif;
        endif;
    }
    
    public function confirm($order_info, $order_total) {
        $code = '';
        
        $start = strpos($order_total['title'], '(') + 1;
        $end = strrpos($order_total['title'], ')');
        
        if ($start && $end):
            $code = substr($order_total['title'], $start, $end - $start);
        endif;
        
        Theme::model('checkout/coupon');
        
        $coupon_info = CheckoutCoupon::getCoupon($code);
        
        if ($coupon_info):
            CheckoutCoupon::redeem($coupon_info['coupon_id'], $order_info['order_id'], $order_info['customer_id'], $order_total['value']);
        endif;
    }
}
