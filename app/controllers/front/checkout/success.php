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

class Success extends Controller {
    
    public function index() {
        if (isset(Session::p()->data['order_id'])) {
            Cart::clear();
            
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
            unset(Session::p()->data['payment_method']);
            unset(Session::p()->data['payment_methods']);
            unset(Session::p()->data['guest']);
            unset(Session::p()->data['comment']);
            unset(Session::p()->data['order_id']);
            unset(Session::p()->data['coupon']);
            unset(Session::p()->data['reward']);
            unset(Session::p()->data['gift_card']);
            unset(Session::p()->data['gift_cards']);
            unset(Session::p()->data['totals']);
            unset(Session::p()->data['paypal']);
        }
        
        $data = Theme::language('checkout/success');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_basket', 'checkout/cart');
        Breadcrumb::add('lang_text_checkout', 'checkout/checkout', null, true, 'SSL');
        Breadcrumb::add('lang_text_success', 'checkout/success');
        
        if (Customer::isLogged()) {
            $data['text_message'] = sprintf(Lang::get('lang_text_customer'), Url::link('account/dashboard', '', 'SSL'), Url::link('account/order', '', 'SSL'), Url::link('account/download', '', 'SSL'), Url::link('content/contact'));
        } else {
            $data['text_message'] = sprintf(Lang::get('lang_text_guest'), Url::link('content/contact'));
        }
        
        $data['continue'] = Url::link('shop/home');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('common/success', $data));
    }
}
