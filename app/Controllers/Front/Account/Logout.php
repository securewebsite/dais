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


namespace App\Controllers\Front\Account;
use App\Controllers\Controller;

class Logout extends Controller {
    public function index() {
        if ($this->customer->isLogged()) {
            
            $customer_id = $this->customer->getId();
            
            $this->customer->logout();
            $this->cart->clear();
            
            unset($this->session->data['wishlist']);
            unset($this->session->data['shipping_address_id']);
            unset($this->session->data['shipping_country_id']);
            unset($this->session->data['shipping_zone_id']);
            unset($this->session->data['shipping_postcode']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_address_id']);
            unset($this->session->data['payment_country_id']);
            unset($this->session->data['payment_zone_id']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
            
            Theme::trigger('front_customer_logout', array('customer_id' => $customer_id));
        }
        
        $data = Theme::language('account/logout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if ($this->customer->isLogged()):
            Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        endif;
        
        Breadcrumb::add('lang_text_logout', 'account/logout', null, true, 'SSL');

        if (Theme::getStyle() == 'content'):
            $route = 'content/home';
        else:
            $route = 'shop/home';
        endif;
        
        $data['continue']     = Url::link($route);
        $data['text_message'] = Lang::get('lang_text_message');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('common/success', $data));
    }
}
