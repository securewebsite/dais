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

namespace App\Controllers\Front\Shop;

use App\Controllers\Controller;

class Cart extends Controller {
    
    public function index() {
        $data = Theme::language('shop/cart');
        
        if (isset(Request::p()->get['remove'])) {
            \Cart::remove(Request::p()->get['remove']);
            
            unset(Session::p()->data['gift_cards'][Request::p()->get['remove']]);
        }
        
        // Totals
        Theme::model('setting/module');
        
        $total_data = array();
        $total = 0;
        $taxes = \Cart::getTaxes();
        
        // Display prices
        if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
            $sort_order = array();
            
            $results = SettingModule::getModules('total');
            
            foreach ($results as $key => $value) {
                $sort_order[$key] = Config::get($value['code'] . '_sort_order');
            }
            
            array_multisort($sort_order, SORT_ASC, $results);
            
            foreach ($results as $result) {
                if (Config::get($result['code'] . '_status')) {
                    Theme::model('total/' . $result['code']);
                    
                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                }
                
                $sort_order = array();
                
                foreach ($total_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }
                
                array_multisort($sort_order, SORT_ASC, $total_data);
            }
        }
        
        $data['totals'] = $total_data;
        
        $data['text_items'] = sprintf(Lang::get('lang_text_items'), \Cart::countProducts() + (isset(Session::p()->data['gift_cards']) ? count(Session::p()->data['gift_cards']) : 0), Currency::format($total));
        
        Theme::model('tool/image');
        
        $data['products'] = array();
        
        foreach (\Cart::getProducts() as $product) {
            if ($product['image']) {
                $image = ToolImage::resize($product['image'], Config::get('config_image_cart_width'), Config::get('config_image_cart_height'));
            } else {
                $image = '';
            }
            
            $option_data = array();
            
            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['option_value'];
                } else {
                    $filename = $this->encryption->decrypt($option['option_value']);
                    
                    $value = Encode::substr($filename, 0, Encode::strrpos($filename, '.'));
                }
                
                $option_data[] = array(
                    'name'  => $option['name'], 
                    'value' => (Encode::strlen($value) > 20 ? Encode::substr($value, 0, 20) . '..' : $value), 
                    'type'  => $option['type']
                );
            }
            
            // Display prices
            if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                $price = Currency::format(Tax::calculate($product['price'], $product['tax_class_id'], Config::get('config_tax')));
            } else {
                $price = false;
            }
            
            // Display prices
            if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                $total = Currency::format(Tax::calculate($product['price'], $product['tax_class_id'], Config::get('config_tax')) * $product['quantity']);
            } else {
                $total = false;
            }
            
            $data['products'][] = array(
                'key'       => $product['key'], 
                'thumb'     => $image, 
                'name'      => $product['name'], 
                'model'     => $product['model'], 
                'option'    => $option_data, 
                'quantity'  => $product['quantity'], 
                'price'     => $price, 
                'total'     => $total, 
                'href'      => Url::link('catalog/product', 'path=' . $product['paths'] . '&product_id=' . $product['product_id']), 
                'recurring' => ($product['recurring'] ? $product['recurring']['name'] : '')
            );
        }
        
        // Gift card
        $data['gift_cards'] = array();
        
        if (!empty(Session::p()->data['gift_cards'])) {
            foreach (Session::p()->data['gift_cards'] as $key => $gift_card) {
                $data['gift_cards'][] = array(
                    'key'         => $key, 
                    'description' => $gift_card['description'], 
                    'amount'      => Currency::format($gift_card['amount'])
                );
            }
        }
        
        $data['cart'] = Url::link('checkout/cart');
        
        $data['checkout'] = Url::link('checkout/checkout', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('shop/cart', $data);
    }
    
    public function info() {
        Response::setOutput($this->index());
    }
}
