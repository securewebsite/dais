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

class Confirm extends Controller {
    
    public function index() {
        $redirect = '';
        
        if (Cart::hasShipping()):
            
            // Validate if shipping address has been set.
            Theme::model('account/address');
            
            if (Customer::isLogged() && isset(Session::p()->data['shipping_address_id'])):
                $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
            elseif (isset(Session::p()->data['guest'])):
                $shipping_address = Session::p()->data['guest']['shipping'];
            endif;
            
            if (empty($shipping_address)):
                $redirect = Url::link('checkout/checkout', '', 'SSL');
            endif;
            
            // Validate if shipping method has been set.
            if (!isset(Session::p()->data['shipping_method'])):
                $redirect = Url::link('checkout/checkout', '', 'SSL');
            endif;
        else:
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
        endif;
        
        // Validate if payment address has been set.
        Theme::model('account/address');
        
        if (Customer::isLogged() && isset(Session::p()->data['payment_address_id'])):
            $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
        elseif (isset(Session::p()->data['guest'])):
            $payment_address = Session::p()->data['guest']['payment'];
        endif;
        
        if (empty($payment_address)):
            $redirect = Url::link('checkout/checkout', '', 'SSL');
        endif;
        
        // Validate if payment method has been set.
        if (!isset(Session::p()->data['payment_method'])):
            $redirect = Url::link('checkout/checkout', '', 'SSL');
        endif;
        
        // Validate cart has products and has stock.
        if ((!Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))):
            $redirect = Url::link('checkout/cart');
        endif;
        
        // Validate minimum quantity requirments.
        $products = Cart::getProducts();
        
        foreach ($products as $product):
            $product_total = 0;
            
            foreach ($products as $product_2):
                if ($product_2['product_id'] == $product['product_id']):
                    $product_total+= $product_2['quantity'];
                endif;
            endforeach;
            
            if ($product['minimum'] > $product_total):
                $redirect = Url::link('checkout/cart');
                break;
            endif;
        endforeach;
        
        if (!$redirect):
            $total_data = array();
            $total      = 0;
            $taxes      = Cart::getTaxes();
            
            Theme::model('setting/module');
            
            $sort_order = array();
            
            $results = SettingModule::getModules('total');
            
            foreach ($results as $key => $value):
                $sort_order[$key] = Config::get($value['code'] . '_sort_order');
            endforeach;
            
            array_multisort($sort_order, SORT_ASC, $results);
            
            foreach ($results as $result):
                if (Config::get($result['code'] . '_status')):
                    Theme::model('total/' . $result['code']);
                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                endif;
            endforeach;
            
            $sort_order = array();
            
            foreach ($total_data as $key => $value):
                $sort_order[$key] = $value['sort_order'];
            endforeach;
            
            array_multisort($sort_order, SORT_ASC, $total_data);
            
            $data = Theme::language('checkout/checkout');
            
            $order = array();
            
            $order['invoice_prefix'] = Config::get('config_invoice_prefix');
            $order['store_id']       = Config::get('config_store_id');
            $order['store_name']     = Config::get('config_name');
            
            if ($order['store_id']):
                $order['store_url'] = Config::get('config_url');
            else:
                $order['store_url'] = Config::get('http.server');
            endif;
            
            if (Customer::isLogged()):
                $order['customer_id']       = Customer::getId();
                $order['customer_group_id'] = Customer::getGroupId();
                $order['firstname']         = Customer::getFirstName();
                $order['lastname']          = Customer::getLastName();
                $order['email']             = Customer::getEmail();
                $order['telephone']         = Customer::getTelephone();
                
                Theme::model('account/address');
                
                $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
            elseif (isset(Session::p()->data['guest'])):
                $order['customer_id']       = 0;
                $order['customer_group_id'] = Session::p()->data['guest']['customer_group_id'];
                $order['firstname']         = Session::p()->data['guest']['firstname'];
                $order['lastname']          = Session::p()->data['guest']['lastname'];
                $order['email']             = Session::p()->data['guest']['email'];
                $order['telephone']         = Session::p()->data['guest']['telephone'];
                
                $payment_address = Session::p()->data['guest']['payment'];
            endif;
            
            $order['payment_firstname']      = $payment_address['firstname'];
            $order['payment_lastname']       = $payment_address['lastname'];
            $order['payment_company']        = $payment_address['company'];
            $order['payment_company_id']     = $payment_address['company_id'];
            $order['payment_tax_id']         = $payment_address['tax_id'];
            $order['payment_address_1']      = $payment_address['address_1'];
            $order['payment_address_2']      = $payment_address['address_2'];
            $order['payment_city']           = $payment_address['city'];
            $order['payment_postcode']       = $payment_address['postcode'];
            $order['payment_zone']           = $payment_address['zone'];
            $order['payment_zone_id']        = $payment_address['zone_id'];
            $order['payment_country']        = $payment_address['country'];
            $order['payment_country_id']     = $payment_address['country_id'];
            $order['payment_address_format'] = $payment_address['address_format'];
            
            if (isset(Session::p()->data['payment_method']['title'])):
                $order['payment_method'] = Session::p()->data['payment_method']['title'];
            else:
                $order['payment_method'] = '';
            endif;
            
            if (isset(Session::p()->data['payment_method']['code'])):
                $order['payment_code'] = Session::p()->data['payment_method']['code'];
            else:
                $order['payment_code'] = '';
            endif;
            
            if (Cart::hasShipping()):
                if (Customer::isLogged()):
                    Theme::model('account/address');
                    $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
                elseif (isset(Session::p()->data['guest'])):
                    $shipping_address = Session::p()->data['guest']['shipping'];
                endif;
                
                $order['shipping_firstname']      = $shipping_address['firstname'];
                $order['shipping_lastname']       = $shipping_address['lastname'];
                $order['shipping_company']        = $shipping_address['company'];
                $order['shipping_address_1']      = $shipping_address['address_1'];
                $order['shipping_address_2']      = $shipping_address['address_2'];
                $order['shipping_city']           = $shipping_address['city'];
                $order['shipping_postcode']       = $shipping_address['postcode'];
                $order['shipping_zone']           = $shipping_address['zone'];
                $order['shipping_zone_id']        = $shipping_address['zone_id'];
                $order['shipping_country']        = $shipping_address['country'];
                $order['shipping_country_id']     = $shipping_address['country_id'];
                $order['shipping_address_format'] = $shipping_address['address_format'];
                
                if (isset(Session::p()->data['shipping_method']['title'])):
                    $order['shipping_method'] = Session::p()->data['shipping_method']['title'];
                else:
                    $order['shipping_method'] = '';
                endif;
                
                if (isset(Session::p()->data['shipping_method']['code'])):
                    $order['shipping_code'] = Session::p()->data['shipping_method']['code'];
                else:
                    $order['shipping_code'] = '';
                endif;
            else:
                $order['shipping_firstname']      = '';
                $order['shipping_lastname']       = '';
                $order['shipping_company']        = '';
                $order['shipping_address_1']      = '';
                $order['shipping_address_2']      = '';
                $order['shipping_city']           = '';
                $order['shipping_postcode']       = '';
                $order['shipping_zone']           = '';
                $order['shipping_zone_id']        = '';
                $order['shipping_country']        = '';
                $order['shipping_country_id']     = '';
                $order['shipping_address_format'] = '';
                $order['shipping_method']         = '';
                $order['shipping_code']           = '';
            endif;
            
            $product_data = array();
            
            foreach (Cart::getProducts() as $product):
                $option_data = array();
                
                foreach ($product['option'] as $option):
                    if ($option['type'] != 'file'):
                        $value = $option['option_value'];
                    else:
                        $value = $this->encryption->decrypt($option['option_value']);
                    endif;
                    
                    $option_data[] = array(
                        'product_option_id'       => $option['product_option_id'], 
                        'product_option_value_id' => $option['product_option_value_id'], 
                        'option_id'               => $option['option_id'], 
                        'option_value_id'         => $option['option_value_id'], 
                        'name'                    => $option['name'], 
                        'value'                   => $value, 
                        'type'                    => $option['type']
                    );
                endforeach;
                
                $product_data[] = array(
                    'product_id' => $product['product_id'], 
                    'name'       => $product['name'], 
                    'model'      => $product['model'], 
                    'option'     => $option_data, 
                    'download'   => $product['download'], 
                    'quantity'   => $product['quantity'], 
                    'subtract'   => $product['subtract'], 
                    'price'      => $product['price'], 
                    'total'      => $product['total'], 
                    'tax'        => Tax::getTax($product['price'], $product['tax_class_id']), 
                    'reward'     => $product['reward']
                );
            endforeach;
            
            // Gift card
            $gift_card_data = array();
            
            if (!empty(Session::p()->data['gift_cards'])):
                foreach (Session::p()->data['gift_cards'] as $gift_card):
                    $gift_card_data[] = array(
                        'description'       => $gift_card['description'], 
                        'code'              => substr(md5(mt_rand()), 0, 10), 
                        'to_name'           => $gift_card['to_name'], 
                        'to_email'          => $gift_card['to_email'], 
                        'from_name'         => $gift_card['from_name'], 
                        'from_email'        => $gift_card['from_email'], 
                        'gift_card_theme_id' => $gift_card['gift_card_theme_id'], 
                        'message'           => $gift_card['message'], 
                        'amount'            => $gift_card['amount']
                    );
                endforeach;
            endif;
            
            $order['products']  = $product_data;
            $order['gift_cards'] = $gift_card_data;
            $order['totals']    = $total_data;
            $order['comment']   = Session::p()->data['comment'];
            $order['total']     = $total;
            
            /**
             * 3 ways to check for an affiliate, listed by precedence:
             * 1. Referral_id of logged in customer
             * 2. Referrer cookie
             * 3. Affiliate_id cookie
             */
            
            /**
             * We'll need our sub_total to calculate the commission
             */
            $sub_total = Cart::getSubTotal();

            // Load model
            
            Theme::model('account/affiliate');

            /**
             * Start with setting affiliate_id to false;
             */
            
            $affiliate_id = false;

            /**
             * Let's handle all logged in customers first
             */
            if (Customer::isLogged() && (Customer::getReferralId() > 0)):
                $affiliate_id = Customer::getReferralId();
            endif;

            /**
             * Not logged in or no referral_id, we can try cookies.
             * make sure we check that the affiliate_id is not already set
             */
            
            // referrer cookie
            if (!$affiliate_id && isset(Request::p()->cookie['referrer'])):
                $affiliate_id = Request::p()->cookie['referrer'];
            endif;
            
            // affiliate_id cookie
            if (!$affiliate_id && isset(Request::p()->cookie['affiliate_id'])):
                $affiliate_id = Request::p()->cookie['affiliate_id'];
            endif;

            if ($affiliate_id && ($affiliate_id !== Customer::getId())):
                $order['affiliate_id'] = $affiliate_id;
                $percent               = AccountAffiliate::getAffiliateCommission($affiliate_id);
                $commission            = $sub_total * ($percent / 100);
                $order['commission']   = number_format($commission, 2);
            else:
                $order['affiliate_id'] = 0;
                $order['commission']   = 0;
            endif;
            
            $order['language_id']    = Config::get('config_language_id');
            $order['currency_id']    = Currency::getId();
            $order['currency_code']  = Currency::getCode();
            $order['currency_value'] = Currency::getValue(Currency::getCode());
            $order['ip']             = Request::p()->server['REMOTE_ADDR'];
            
            if (!empty(Request::p()->server['HTTP_X_FORWARDED_FOR'])):
                $order['forwarded_ip'] = Request::p()->server['HTTP_X_FORWARDED_FOR'];
            elseif (!empty(Request::p()->server['HTTP_CLIENT_IP'])):
                $order['forwarded_ip'] = Request::p()->server['HTTP_CLIENT_IP'];
            else:
                $order['forwarded_ip'] = '';
            endif;
            
            if (isset(Request::p()->server['HTTP_USER_AGENT'])):
                $order['user_agent'] = Request::p()->server['HTTP_USER_AGENT'];
            else:
                $order['user_agent'] = '';
            endif;
            
            if (isset(Request::p()->server['HTTP_ACCEPT_LANGUAGE'])):
                $order['accept_language'] = Request::p()->server['HTTP_ACCEPT_LANGUAGE'];
            else:
                $order['accept_language'] = '';
            endif;
            
            Theme::model('checkout/order');
            
            Session::p()->data['order_id'] = CheckoutOrder::addOrder($order);
            
            $data['products'] = array();
            
            foreach (Cart::getProducts() as $product):
                $option_data = array();
                
                foreach ($product['option'] as $option):
                    if ($option['type'] != 'file'):
                        $value = $option['option_value'];
                    else:
                        $filename = $this->encryption->decrypt($option['option_value']);    
                        $value    = Encode::substr($filename, 0, Encode::strrpos($filename, '.'));
                    endif;
                    
                    $option_data[] = array(
                        'name'  => $option['name'], 
                        'value' => (Encode::strlen($value) > 20 ? Encode::substr($value, 0, 20) . '..' : $value)
                    );
                endforeach;
                
                $recurring = '';
                
                if ($product['recurring']):
                    $frequencies = array(
                        'day'        => Lang::get('lang_text_day'), 
                        'week'       => Lang::get('lang_text_week'), 
                        'semi_month' => Lang::get('lang_text_semi_month'), 
                        'month'      => Lang::get('lang_text_month'), 
                        'year'       => Lang::get('lang_text_year')
                    );
                    
                    if ($product['recurring']['trial']):
                        $recurring = sprintf(Lang::get('lang_text_trial_description'), Currency::format(Tax::calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    endif;
                    
                    if ($product['recurring']['duration']):
                        $recurring.= sprintf(Lang::get('lang_text_payment_description'), Currency::format(Tax::calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    else:
                        $recurring.= sprintf(Lang::get('lang_text_payment_until_canceled_description'), Currency::format(Tax::calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    endif;
                endif;
                
                $data['products'][] = array(
                    'key'        => $product['key'], 
                    'product_id' => $product['product_id'], 
                    'name'       => $product['name'], 
                    'model'      => $product['model'], 
                    'option'     => $option_data, 
                    'quantity'   => $product['quantity'], 
                    'subtract'   => $product['subtract'], 
                    'price'      => Currency::format(Tax::calculate($product['price'], $product['tax_class_id'], Config::get('config_tax'))), 
                    'total'      => Currency::format(Tax::calculate($product['price'], $product['tax_class_id'], Config::get('config_tax')) * $product['quantity']), 
                    'href'       => Url::link('catalog/product', 'product_id=' . $product['product_id']), 
                    'recurring'  => $recurring
                );
            endforeach;
            
            // Gift Giftcard
            $data['gift_cards'] = array();
            
            if (!empty(Session::p()->data['gift_cards'])):
                foreach (Session::p()->data['gift_cards'] as $gift_card):
                    $data['gift_cards'][] = array(
                        'description' => $gift_card['description'], 
                        'amount'      => Currency::format($gift_card['amount'])
                    );
                endforeach;
            endif;
            
            $data['totals']  = $total_data;
            $data['payment'] = Theme::controller('payment/' . Session::p()->data['payment_method']['code']);
        else:
            $data['redirect'] = $redirect;
        endif;
        
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::render('checkout/confirm', $data));
    }
}
