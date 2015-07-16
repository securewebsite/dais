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

namespace App\Controllers\Front\Payment;

use App\Controllers\Controller;

class TwoCheckout extends Controller {
    
    public function index() {
        $data = Theme::language('payment/two_checkout');
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder($this->session->data['order_id']);
        
        $data['action'] = 'https://www.2checkout.com/checkout/spurchase';
        
        $data['sid'] = Config::get('two_checkout_account');
        $data['total'] = Currency::format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['cart_order_id'] = $this->session->data['order_id'];
        $data['card_holder_name'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
        $data['street_address'] = $order_info['payment_address_1'];
        $data['city'] = $order_info['payment_city'];
        
        if ($order_info['payment_iso_code_2'] == 'US' || $order_info['payment_iso_code_2'] == 'CA') {
            $data['state'] = $order_info['payment_zone'];
        } else {
            $data['state'] = 'XX';
        }
        
        $data['zip'] = $order_info['payment_postcode'];
        $data['country'] = $order_info['payment_country'];
        $data['email'] = $order_info['email'];
        $data['phone'] = $order_info['telephone'];
        
        if (Cart::hasShipping()) {
            $data['ship_street_address'] = $order_info['shipping_address_1'];
            $data['ship_city'] = $order_info['shipping_city'];
            $data['ship_state'] = $order_info['shipping_zone'];
            $data['ship_zip'] = $order_info['shipping_postcode'];
            $data['ship_country'] = $order_info['shipping_country'];
        } else {
            $data['ship_street_address'] = $order_info['payment_address_1'];
            $data['ship_city'] = $order_info['payment_city'];
            $data['ship_state'] = $order_info['payment_zone'];
            $data['ship_zip'] = $order_info['payment_postcode'];
            $data['ship_country'] = $order_info['payment_country'];
        }
        
        $data['products'] = array();
        
        $products = Cart::getProducts();
        
        foreach ($products as $product) {
            $data['products'][] = array('product_id' => $product['product_id'], 'name' => $product['name'], 'description' => $product['name'], 'quantity' => $product['quantity'], 'price' => Currency::format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false));
        }
        
        if (Config::get('two_checkout_test')) {
            $data['demo'] = 'Y';
        } else {
            $data['demo'] = '';
        }
        
        $data['lang'] = $this->session->data['language'];
        
        $data['return_url'] = Url::link('payment/two_checkout/callback', '', 'SSL');
        
        Theme::loadjs('javascript/payment/two_checkout', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return View::render('payment/two_checkout', $data);
    }
    
    public function callback() {
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder($this->request->post['cart_order_id']);
        
        if (!Config::get('two_checkout_test')) {
            $order_number = $this->request->post['order_number'];
        } else {
            $order_number = '1';
        }
        
        if (strtoupper(md5(Config::get('two_checkout_secret') . Config::get('two_checkout_account') . $order_number . $this->request->post['total'])) == $this->request->post['key']) {
            if (Currency::format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false) == $this->request->post['total']) {
                CheckoutOrder::confirm($this->request->post['cart_order_id'], Config::get('two_checkout_order_status_id'));
            } else {
                CheckoutOrder::confirm($this->request->post['cart_order_id'], Config::get('config_order_status_id'));
                 // Ugh. Some one've faked the sum. What should we do? Probably drop a mail to the shop owner?
                
            }
            
            // We can't use Response::redirect() here, because of 2CO behavior. It fetches this page
            // on behalf of the user and thus user (and his browser) see this as located at 2checkout.com
            // domain. So user's cookies are not here and he will see empty basket and probably other
            // weird things.
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            echo '<html>' . "\n";
            echo '<head>' . "\n";
            echo '  <meta http-equiv="Refresh" content="0; url=' . Url::link('checkout/success') . '">' . "\n";
            echo '</head>' . "\n";
            echo '<body>' . "\n";
            echo '  <p>Please follow <a href="' . Url::link('checkout/success') . '">link</a>!</p>' . "\n";
            echo '</body>' . "\n";
            echo '</html>' . "\n";
        } else {
            trigger_error('The response from 2checkout.com can\'t be parsed. Contact site administrator, please!');
        }
    }
}
