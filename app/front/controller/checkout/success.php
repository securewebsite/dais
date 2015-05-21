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

namespace Front\Controller\Checkout;
use Dais\Engine\Controller;

class Success extends Controller {
    public function index() {
        if (isset($this->session->data['order_id'])) {
            $this->cart->clear();
            
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
        
        $data = $this->theme->language('checkout/success');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_text_basket', 'checkout/cart');
        $this->breadcrumb->add('lang_text_checkout', 'checkout/checkout', null, true, 'SSL');
        $this->breadcrumb->add('lang_text_success', 'checkout/success');
        
        if ($this->customer->isLogged()) {
            $data['text_message'] = sprintf($this->language->get('lang_text_customer'), $this->url->link('account/dashboard', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('content/contact'));
        } else {
            $data['text_message'] = sprintf($this->language->get('lang_text_guest'), $this->url->link('content/contact'));
        }
        
        $data['continue'] = $this->url->link('shop/home');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('common/success', $data));
    }
}
