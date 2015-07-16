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
        if (isset($this->session->data['order_id'])) {
            Cart::clear();
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
            unset($this->session->data['totals']);
            unset($this->session->data['paypal']);
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
