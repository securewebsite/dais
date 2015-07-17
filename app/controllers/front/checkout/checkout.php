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

namespace App\Controllers\Front\Checkout;

use App\Controllers\Controller;

class Checkout extends Controller {
    
    public function index() {
        
        // Validate cart has products and has stock.
        if ((!Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            Response::redirect(Url::link('checkout/cart'));
        }
        
        // Validate minimum quantity requirments.
        $products = Cart::getProducts();
        
        foreach ($products as $product) {
            $product_total = 0;
            
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total+= $product_2['quantity'];
                }
            }
            
            if ($product['minimum'] > $product_total) {
                Response::redirect(Url::link('checkout/cart'));
            }
        }
        
        $data = Theme::language('checkout/checkout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_cart', 'checkout/cart');
        Breadcrumb::add('lang_heading_title', 'checkout/checkout', null, true, 'SSL');
        
        $data['logged'] = Customer::isLogged();
        $data['shipping_required'] = Cart::hasShipping();
        
        Theme::loadjs('javascript/checkout/checkout', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        if (isset(Request::p()->get['quickconfirm'])) {
            $data['quickconfirm'] = Request::p()->get['quickconfirm'];
        }
        
        Response::setOutput(View::render('checkout/checkout', $data));
    }
    
    public function country() {
        $json = array();
        
        Theme::model('locale/country');
        
        $country_info = LocaleCountry::getCountry(Request::p()->get['country_id']);
        
        if ($country_info) {
            Theme::model('locale/zone');
            
            $json = array('country_id' => $country_info['country_id'], 'name' => $country_info['name'], 'iso_code_2' => $country_info['iso_code_2'], 'iso_code_3' => $country_info['iso_code_3'], 'address_format' => $country_info['address_format'], 'postcode_required' => $country_info['postcode_required'], 'zone' => LocaleZone::getZonesByCountryId(Request::p()->get['country_id']), 'status' => $country_info['status']);
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
