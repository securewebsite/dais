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

class PaypalExpress extends Controller {
    
    public function index() {
        $data = Theme::language('payment/paypal_express');
        
        $data['button_continue_action'] = Url::link('payment/paypal_express/checkout', '', 'SSL');
        
        /**
         * if there is any other paypal session data, clear it
         */
        unset(Session::p()->data['paypal']);
        
        Theme::loadjs('javascript/payment/paypal_express', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return View::make('payment/paypal_express', $data);
    }
    
    public function express() {
        if ((!Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $this->log->write('No product redirect');
            Response::redirect(Url::link('checkout/cart'));
        }
        
        if (Customer::isLogged()) {
            
            /**
             * If the customer is already logged in
             */
            Session::p()->data['paypal']['guest'] = false;
            unset(Session::p()->data['guest']);
        } else {
            if (Config::get('config_checkout_guest') && !Config::get('config_customer_price') && !Cart::hasDownload() && !Cart::hasRecurringProducts()) {
                
                /**
                 * If the guest checkout is allowed (config ok, no login for price and doesn't have downloads)
                 */
                Session::p()->data['paypal']['guest'] = true;
            } else {
                
                /**
                 * If guest checkout disabled or login is required before price or order has downloads
                 *
                 * Send them to the normal checkout flow.
                 */
                unset(Session::p()->data['guest']);
                Response::redirect(Url::link('checkout/checkout', '', 'SSL'));
            }
        }
        
        unset(Session::p()->data['shipping_method']);
        unset(Session::p()->data['shipping_methods']);
        unset(Session::p()->data['payment_method']);
        unset(Session::p()->data['payment_methods']);
        
        Theme::model('payment/paypal_express');
        Theme::model('tool/image');
        
        if (Cart::hasShipping()) {
            $shipping = 2;
        } else {
            $shipping = 1;
        }
        
        $max_amount = Currency::convert(Cart::getTotal(), Config::get('config_currency'), 'USD');
        $max_amount = min($max_amount * 1.5, 10000);
        $max_amount = Currency::format($max_amount, Currency::getCode(), '', false);
        
        $data = array(
            'METHOD'             => 'SetExpressCheckout', 
            'MAXAMT'             => $max_amount, 
            'RETURNURL'          => Url::link('payment/paypal_express/expressReturn', '', 'SSL'), 
            'CANCELURL'          => Url::link('checkout/cart', '', 'SSL'), 
            'REQCONFIRMSHIPPING' => 0, 
            'NOSHIPPING'         => $shipping, 
            'ALLOWNOTE'          => Config::get('paypal_express_allow_note'), 
            'LOCALECODE'         => 'EN', 
            'LANDINGPAGE'        => 'Login', 
            'HDRIMG'             => ToolImage::resize(Config::get('paypal_express_logo'), 790, 90), 
            'PAYFLOWCOLOR'       => Config::get('paypal_express_page_colour'), 
            'CHANNELTYPE'        => 'Merchant'
        );
        
        if (isset(Session::p()->data['paypal_express_login']['seamless']['access_token']) && (isset(Session::p()->data['paypal_express_login']['seamless']['customer_id']) && Session::p()->data['paypal_express_login']['seamless']['customer_id'] == Customer::getId()) && Config::get('paypal_express_login_seamless')) {
            $data['IDENTITYACCESSTOKEN'] = Session::p()->data['paypal_express_login']['seamless']['access_token'];
        }
        
        $data = array_merge($data, PaymentPaypalExpress::paymentRequestInfo());
        
        $result = PaymentPaypalExpress::call($data);
        
        /**
         * If a failed PayPal setup happens, handle it.
         */
        if (!isset($result['TOKEN'])) {
            Session::p()->data['error'] = $result['L_LONGMESSAGE0'];
            
            /**
             * Unable to add error message to user as the session errors/success are not
             * used on the cart or checkout pages - need to be added?
             * If PayPal debug log is off then still log error to normal error log.
             */
            if (Config::get('paypal_express_debug') == 1) {
                $this->log->write(serialize($result));
            }
            
            Response::redirect(Url::link('checkout/checkout', '', 'SSL'));
        }
        
        Session::p()->data['paypal']['token'] = $result['TOKEN'];
        
        if (Config::get('paypal_express_test') == 1) {
            header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN']);
        } else {
            header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN']);
        }
    }
    
    public function expressReturn() {
        
        /**
         * This is the url when PayPal has completed the auth.
         *
         * It has no output, instead it sets the data and locates to checkout
         */
        Theme::model('payment/paypal_express');
        $data = array(
            'METHOD' => 'GetExpressCheckoutDetails', 
            'TOKEN'  => Session::p()->data['paypal']['token']
        );
        
        $result = PaymentPaypalExpress::call($data);
        Session::p()->data['paypal']['payerid'] = $result['PAYERID'];
        Session::p()->data['paypal']['result']  = $result;
        
        Session::p()->data['comment'] = '';
        if (isset($result['PAYMENTREQUEST_0_NOTETEXT'])) {
            Session::p()->data['comment'] = $result['PAYMENTREQUEST_0_NOTETEXT'];
        }
        
        if (Session::p()->data['paypal']['guest'] === true) {
            
            Session::p()->data['guest']['customer_group_id'] = Config::get('config_default_visibility');
            Session::p()->data['guest']['firstname']         = trim($result['FIRSTNAME']);
            Session::p()->data['guest']['lastname']          = trim($result['LASTNAME']);
            Session::p()->data['guest']['email']             = trim($result['EMAIL']);

            if (isset($result['PHONENUM'])) {
                Session::p()->data['guest']['telephone'] = $result['PHONENUM'];
            } else {
                Session::p()->data['guest']['telephone'] = '';
            }
            
            Session::p()->data['guest']['payment']['firstname'] = trim($result['FIRSTNAME']);
            Session::p()->data['guest']['payment']['lastname']  = trim($result['LASTNAME']);
            
            if (isset($result['BUSINESS'])) {
                Session::p()->data['guest']['payment']['company'] = $result['BUSINESS'];
            } else {
                Session::p()->data['guest']['payment']['company'] = '';
            }
            
            Session::p()->data['guest']['payment']['company_id'] = '';
            Session::p()->data['guest']['payment']['tax_id']     = '';
            
            if (Cart::hasShipping()) {
                $shipping_name       = explode(' ', trim($result['PAYMENTREQUEST_0_SHIPTONAME']));
                $shipping_first_name = $shipping_name[0];
                unset($shipping_name[0]);
                $shipping_last_name  = implode(' ', $shipping_name);
                
                Session::p()->data['guest']['payment']['address_1'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET'];
                
                if (isset($result['PAYMENTREQUEST_0_SHIPTOSTREET2'])) {
                    Session::p()->data['guest']['payment']['address_2'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET2'];
                } else {
                    Session::p()->data['guest']['payment']['address_2'] = '';
                }
                
                Session::p()->data['guest']['payment']['postcode']   = $result['PAYMENTREQUEST_0_SHIPTOZIP'];
                Session::p()->data['guest']['payment']['city']       = $result['PAYMENTREQUEST_0_SHIPTOCITY'];
                
                Session::p()->data['guest']['shipping']['firstname'] = $shipping_first_name;
                Session::p()->data['guest']['shipping']['lastname']  = $shipping_last_name;
                Session::p()->data['guest']['shipping']['company']   = '';
                Session::p()->data['guest']['shipping']['address_1'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET'];
                
                if (isset($result['PAYMENTREQUEST_0_SHIPTOSTREET2'])) {
                    Session::p()->data['guest']['shipping']['address_2'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET2'];
                } else {
                    Session::p()->data['guest']['shipping']['address_2'] = '';
                }
                
                Session::p()->data['guest']['shipping']['postcode'] = $result['PAYMENTREQUEST_0_SHIPTOZIP'];
                Session::p()->data['guest']['shipping']['city']     = $result['PAYMENTREQUEST_0_SHIPTOCITY'];
                
                Session::p()->data['shipping_postcode']             = $result['PAYMENTREQUEST_0_SHIPTOZIP'];
                
                $country_info = $this->db->query("
					SELECT * 
					FROM `{$this->db->prefix}country` 
					WHERE `iso_code_2` = '" . $this->db->escape($result['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) . "' 
					AND `status` = '1' 
					LIMIT 1")->row;
                
                if ($country_info) {
                    Session::p()->data['guest']['shipping']['country_id']     = $country_info['country_id'];
                    Session::p()->data['guest']['shipping']['country']        = $country_info['name'];
                    Session::p()->data['guest']['shipping']['iso_code_2']     = $country_info['iso_code_2'];
                    Session::p()->data['guest']['shipping']['iso_code_3']     = $country_info['iso_code_3'];
                    Session::p()->data['guest']['shipping']['address_format'] = $country_info['address_format'];
                    Session::p()->data['guest']['payment']['country_id']      = $country_info['country_id'];
                    Session::p()->data['guest']['payment']['country']         = $country_info['name'];
                    Session::p()->data['guest']['payment']['iso_code_2']      = $country_info['iso_code_2'];
                    Session::p()->data['guest']['payment']['iso_code_3']      = $country_info['iso_code_3'];
                    Session::p()->data['guest']['payment']['address_format']  = $country_info['address_format'];
                    Session::p()->data['shipping_country_id']                 = $country_info['country_id'];
                } else {
                    Session::p()->data['guest']['shipping']['country_id']     = '';
                    Session::p()->data['guest']['shipping']['country']        = '';
                    Session::p()->data['guest']['shipping']['iso_code_2']     = '';
                    Session::p()->data['guest']['shipping']['iso_code_3']     = '';
                    Session::p()->data['guest']['shipping']['address_format'] = '';
                    Session::p()->data['guest']['payment']['country_id']      = '';
                    Session::p()->data['guest']['payment']['country']         = '';
                    Session::p()->data['guest']['payment']['iso_code_2']      = '';
                    Session::p()->data['guest']['payment']['iso_code_3']      = '';
                    Session::p()->data['guest']['payment']['address_format']  = '';
                    Session::p()->data['shipping_country_id']                 = '';
                }
                
                if (isset($result['PAYMENTREQUEST_0_SHIPTOSTATE'])) {
                    $returned_shipping_zone = $result['PAYMENTREQUEST_0_SHIPTOSTATE'];
                } else {
                    $returned_shipping_zone = '';
                }
                
                $zone_info = $this->db->query("
					SELECT * 
					FROM `{$this->db->prefix}zone` 
					WHERE (`name` = '" . $this->db->escape($returned_shipping_zone) . "' OR `code` = '" . $this->db->escape($returned_shipping_zone) . "') 
					AND `status` = '1' 
					AND `country_id` = '" . (int)$country_info['country_id'] . "' 
					LIMIT 1")->row;
                
                if ($zone_info) {
                    Session::p()->data['guest']['shipping']['zone']      = $zone_info['name'];
                    Session::p()->data['guest']['shipping']['zone_code'] = $zone_info['code'];
                    Session::p()->data['guest']['shipping']['zone_id']   = $zone_info['zone_id'];
                    Session::p()->data['guest']['payment']['zone']       = $zone_info['name'];
                    Session::p()->data['guest']['payment']['zone_code']  = $zone_info['code'];
                    Session::p()->data['guest']['payment']['zone_id']    = $zone_info['zone_id'];
                    Session::p()->data['shipping_zone_id']               = $zone_info['zone_id'];
                } else {
                    Session::p()->data['guest']['shipping']['zone']      = '';
                    Session::p()->data['guest']['shipping']['zone_code'] = '';
                    Session::p()->data['guest']['shipping']['zone_id']   = '';
                    Session::p()->data['guest']['payment']['zone']       = '';
                    Session::p()->data['guest']['payment']['zone_code']  = '';
                    Session::p()->data['guest']['payment']['zone_id']    = '';
                    Session::p()->data['shipping_zone_id']               = '';
                }
                
                Session::p()->data['guest']['shipping_address'] = true;
            } else {
                Session::p()->data['guest']['payment']['address_1']      = '';
                Session::p()->data['guest']['payment']['address_2']      = '';
                Session::p()->data['guest']['payment']['postcode']       = '';
                Session::p()->data['guest']['payment']['city']           = '';
                Session::p()->data['guest']['payment']['country_id']     = '';
                Session::p()->data['guest']['payment']['country']        = '';
                Session::p()->data['guest']['payment']['iso_code_2']     = '';
                Session::p()->data['guest']['payment']['iso_code_3']     = '';
                Session::p()->data['guest']['payment']['address_format'] = '';
                Session::p()->data['guest']['payment']['zone']           = '';
                Session::p()->data['guest']['payment']['zone_code']      = '';
                Session::p()->data['guest']['payment']['zone_id']        = '';
                Session::p()->data['guest']['shipping_address']          = false;
            }
            
            Session::p()->data['account'] = 'guest';
            
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
            unset(Session::p()->data['payment_method']);
            unset(Session::p()->data['payment_methods']);
        } else {
            unset(Session::p()->data['guest']);
            
            /**
             * if the user is logged in, add the address to the account and set the ID.
             */
            
            if (Cart::hasShipping()) {
                Theme::model('account/address');
                
                $addresses = AccountAddress::getAddresses();
                
                /**
                 * Compare all of the user addresses and see if there is a match
                 */
                $match = false;
                foreach ($addresses as $address) {
                    if (trim(strtolower($address['address_1'])) == trim(strtolower($result['PAYMENTREQUEST_0_SHIPTOSTREET'])) && trim(strtolower($address['postcode'])) == trim(strtolower($result['PAYMENTREQUEST_0_SHIPTOZIP']))) {
                        $match = true;
                        
                        Session::p()->data['payment_address_id']  = $address['address_id'];
                        Session::p()->data['payment_country_id']  = $address['country_id'];
                        Session::p()->data['payment_zone_id']     = $address['zone_id'];
                        
                        Session::p()->data['shipping_address_id'] = $address['address_id'];
                        Session::p()->data['shipping_country_id'] = $address['country_id'];
                        Session::p()->data['shipping_zone_id']    = $address['zone_id'];
                        Session::p()->data['shipping_postcode']   = $address['postcode'];
                        
                        break;
                    }
                }
                
                /**
                 * If there is no address match add the address and set the info.
                 */
                if ($match === false) {
                    
                    $shipping_name = explode(' ', trim($result['PAYMENTREQUEST_0_SHIPTONAME']));
                    $shipping_first_name = $shipping_name[0];
                    unset($shipping_name[0]);
                    $shipping_last_name = implode(' ', $shipping_name);
                    
                    $country_info = $this->db->query("
						SELECT * 
						FROM `{$this->db->prefix}country` 
						WHERE `iso_code_2` = '" . $this->db->escape($result['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) . "' 
						AND `status` = '1' 
						LIMIT 1")->row;
                    
                    $zone_info = $this->db->query("
						SELECT * 
						FROM `{$this->db->prefix}zone` 
						WHERE `name` = '" . $this->db->escape($result['PAYMENTREQUEST_0_SHIPTOSTATE']) . "' 
						AND `status` = '1' 
						AND `country_id` = '" . (int)$country_info['country_id'] . "'")->row;
                    
                    $address_data = array(
                        'firstname'  => $shipping_first_name, 
                        'lastname'   => $shipping_last_name, 
                        'company'    => '', 
                        'company_id' => '', 
                        'tax_id'     => '', 
                        'address_1'  => $result['PAYMENTREQUEST_0_SHIPTOSTREET'], 
                        'address_2'  => (isset($result['PAYMENTREQUEST_0_SHIPTOSTREET2']) ? $result['PAYMENTREQUEST_0_SHIPTOSTREET2'] : ''), 
                        'postcode'   => $result['PAYMENTREQUEST_0_SHIPTOZIP'], 
                        'city'       => $result['PAYMENTREQUEST_0_SHIPTOCITY'], 
                        'zone_id'    => (isset($zone_info['zone_id']) ? $zone_info['zone_id'] : 0), 
                        'country_id' => (isset($country_info['country_id']) ? $country_info['country_id'] : 0)
                    );
                    
                    $address_id = AccountAddress::addAddress($address_data);
                    
                    Session::p()->data['payment_address_id']  = $address_id;
                    Session::p()->data['payment_country_id']  = $address_data['country_id'];
                    Session::p()->data['payment_zone_id']     = $address_data['zone_id'];
                    
                    Session::p()->data['shipping_address_id'] = $address_id;
                    Session::p()->data['shipping_country_id'] = $address_data['country_id'];
                    Session::p()->data['shipping_zone_id']    = $address_data['zone_id'];
                    Session::p()->data['shipping_postcode']   = $address_data['postcode'];
                }
            } else {
                Session::p()->data['payment_address_id'] = '';
                Session::p()->data['payment_country_id'] = '';
                Session::p()->data['payment_zone_id']    = '';
            }
        }
        
        Response::redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
    }
    
    public function expressConfirm() {
        $data = Theme::language('payment/paypal_express');
        $data = Theme::language('checkout/cart', $data);
        
        Theme::model('tool/image');
        
        // Coupon
        if (isset(Request::p()->post['coupon']) && $this->validateCoupon()) {
            Session::p()->data['coupon']  = Request::p()->post['coupon'];
            Session::p()->data['success'] = Lang::get('lang_text_coupon');
            Response::redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
        }
        
        // Gift card
        if (isset(Request::p()->post['gift_card']) && $this->validateGiftcard()) {
            Session::p()->data['gift_card'] = Request::p()->post['gift_card'];
            Session::p()->data['success'] = Lang::get('lang_text_gift_card');
            Response::redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
        }
        
        // Reward
        if (isset(Request::p()->post['reward']) && $this->validateReward()) {
            Session::p()->data['reward']  = abs(Request::p()->post['reward']);
            Session::p()->data['success'] = Lang::get('lang_text_reward');
            Response::redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
        }
        
        Theme::setTitle(Lang::get('lang_express_text_title'));
        
        $data['heading_title'] = Lang::get('lang_express_text_title');
        
        Breadcrumb::add('lang_text_title', 'payment/paypal_express/express', '', true, 'SSL');
        Breadcrumb::add('lang_express_text_title', 'payment/paypal_express/expressConfirm', '', true, 'SSL');
        
        $points_total = 0;
        
        foreach (Cart::getProducts() as $product) {
            if ($product['points']) {
                $points_total+= $product['points'];
            }
        }
        
        $data['button_shipping'] = Lang::get('lang_express_button_shipping');
        $data['button_confirm']  = Lang::get('lang_express_button_confirm');
        
        if (isset(Request::p()->post['next'])) {
            $data['next'] = Request::p()->post['next'];
        } else {
            $data['next'] = '';
        }
        
        $data['action'] = Url::link('payment/paypal_express/expressConfirm', '', 'SSL');
        
        $products = Cart::getProducts();
        
        foreach ($products as $product) {
            $product_total = 0;
            
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total+= $product_2['quantity'];
                }
            }
            
            if ($product['minimum'] > $product_total) {
                $data['error_warning'] = sprintf(Lang::get('lang_error_minimum'), $product['name'], $product['minimum']);
            }
            
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
                    
                    $value    = Encode::substr($filename, 0, Encode::strrpos($filename, '.'));
                }
                
                $option_data[] = array(
                    'name'  => $option['name'], 
                    'value' => (Encode::strlen($value) > 20 ? Encode::substr($value, 0, 20) . '..' : $value)
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
            
            $recurring_description = '';
            
            if ($product['recurring']) {
                $frequencies = array(
                    'day'        => Lang::get('lang_text_day'), 
                    'week'       => Lang::get('lang_text_week'), 
                    'semi_month' => Lang::get('lang_text_semi_month'), 
                    'month'      => Lang::get('lang_text_month'), 
                    'year'       => Lang::get('lang_text_year')
                );
                
                if ($product['recurring']['trial']) {
                    $recurring_price = Currency::format(Tax::calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax')));
                    $recurring_description = sprintf(Lang::get('lang_text_trial_description'), $recurring_price, $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                }
                
                $recurring_price = Currency::format(Tax::calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax')));
                
                if ($product['recurring']['duration']) {
                    $recurring_description.= sprintf(Lang::get('lang_text_payment_description'), $recurring_price, $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                } else {
                    $recurring_description.= sprintf(Lang::get('lang_text_payment_until_canceled_description'), $recurring_price, $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                }
            }
            
            $data['products'][] = array(
                'key'                   => $product['key'], 
                'thumb'                 => $image, 
                'name'                  => $product['name'], 
                'model'                 => $product['model'], 
                'option'                => $option_data, 
                'quantity'              => $product['quantity'], 
                'stock'                 => $product['stock'] ? true : !(!Config::get('config_stock_checkout') || Config::get('config_stock_warning')), 
                'reward'                => ($product['reward'] ? sprintf(Lang::get('lang_text_points'), $product['reward']) : ''), 
                'price'                 => $price, 
                'total'                 => $total, 
                'href'                  => Url::link('product/product', 'product_id=' . $product['product_id']), 
                'remove'                => Url::link('checkout/cart', 'remove=' . $product['key']), 
                'recurring'             => $product['recurring'], 
                'recurring_name'        => (isset($product['recurring']['recurring_name']) ? $product['recurring']['recurring_name'] : ''), 
                'recurring_description' => $recurring_description
            );
        }
        
        $data['gift_cards'] = array();
        
        if (Cart::hasShipping()) {
            
            $data['has_shipping'] = true;
            
            /**
             * Shipping services
             */
            if (Customer::isLogged()) {
                Theme::model('account/address');
                $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
            } elseif (isset(Session::p()->data['guest'])) {
                $shipping_address = Session::p()->data['guest']['shipping'];
            }
            
            if (!empty($shipping_address)) {
                
                // Shipping Methods
                $quote_data = array();
                
                Theme::model('setting/module');
                
                $results = SettingModule::getModules('shipping');
                
                if (!empty($results)) {
                    foreach ($results as $result) {
                        if (Config::get($result['code'] . '_status')) {
                            Theme::model('shipping/' . $result['code']);
                            
                            $quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);
                            
                            if ($quote) {
                                $quote_data[$result['code']] = array(
                                    'title'      => $quote['title'], 
                                    'quote'      => $quote['quote'], 
                                    'sort_order' => $quote['sort_order'], 
                                    'error'      => $quote['error']
                                );
                            }
                        }
                    }
                    
                    if (!empty($quote_data)) {
                        $sort_order = array();
                        
                        foreach ($quote_data as $key => $value) {
                            $sort_order[$key] = $value['sort_order'];
                        }
                        
                        array_multisort($sort_order, SORT_ASC, $quote_data);
                        
                        Session::p()->data['shipping_methods'] = $quote_data;
                        $data['shipping_methods'] = $quote_data;
                        
                        if (!isset(Session::p()->data['shipping_method'])) {
                            
                            //default the shipping to the very first option.
                            $key1 = key($quote_data);
                            $key2 = key($quote_data[$key1]['quote']);
                            Session::p()->data['shipping_method'] = $quote_data[$key1]['quote'][$key2];
                        }
                        
                        $data['code'] = Session::p()->data['shipping_method']['code'];
                        $data['action_shipping'] = Url::link('payment/paypal_express/shipping', '', 'SSL');
                    } else {
                        unset(Session::p()->data['shipping_methods']);
                        unset(Session::p()->data['shipping_method']);
                        $data['error_no_shipping'] = Lang::get('lang_error_no_shipping');
                    }
                } else {
                    unset(Session::p()->data['shipping_methods']);
                    unset(Session::p()->data['shipping_method']);
                    $data['error_no_shipping'] = Lang::get('lang_error_no_shipping');
                }
            }
        } else {
            $data['has_shipping'] = false;
        }
        
        // Totals
        Theme::model('setting/module');
        
        $total_data = array();
        $total      = 0;
        $taxes      = Cart::getTaxes();
        
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
            }
            
            $sort_order = array();
            
            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }
            
            array_multisort($sort_order, SORT_ASC, $total_data);
        }
        
        $data['totals'] = array();
        
        foreach ($total_data as $total) {
            $data['totals'][] = array(
                'title' => $total['title'], 
                'text'  => Currency::format($total['value'])
            );
        }
        
        /**
         * Payment methods
         */
        if (Customer::isLogged() && isset(Session::p()->data['payment_address_id'])) {
            Theme::model('account/address');
            $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
        } elseif (isset(Session::p()->data['guest'])) {
            $payment_address = Session::p()->data['guest']['payment'];
        }
        
        $method_data = array();
        
        Theme::model('setting/module');
        
        $results = SettingModule::getModules('payment');
        
        foreach ($results as $result) {
            if (Config::get($result['code'] . '_status')) {
                Theme::model('payment/' . $result['code']);
                
                $method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);
                
                if ($method) {
                    $method_data[$result['code']] = $method;
                }
            }
        }
        
        $sort_order = array();
        
        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }
        
        array_multisort($sort_order, SORT_ASC, $method_data);
        
        Session::p()->data['payment_methods'] = $method_data;
        Session::p()->data['payment_method']  = Session::p()->data['payment_methods']['paypal_express'];
        
        $data['action_confirm'] = Url::link('payment/paypal_express/expressComplete', '', 'SSL');
        
        if (isset(Session::p()->data['error_warning'])) {
            $data['error_warning'] = Session::p()->data['error_warning'];
            unset(Session::p()->data['error_warning']);
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset(Session::p()->data['attention'])) {
            $data['attention'] = Session::p()->data['attention'];
            unset(Session::p()->data['attention']);
        } else {
            $data['attention'] = '';
        }
        
        Theme::loadjs('javascript/payment/paypal_express_confirm', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('payment/paypal_express_confirm', $data));
    }
    
    public function expressComplete() {
        $data     = Theme::language('payment/paypal_express');
        $redirect = '';
        
        if (Cart::hasShipping()) {
            
            // Validate if shipping address has been set.
            Theme::model('account/address');
            
            if (Customer::isLogged() && isset(Session::p()->data['shipping_address_id'])) {
                $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
            } elseif (isset(Session::p()->data['guest'])) {
                $shipping_address = Session::p()->data['guest']['shipping'];
            }
            
            if (empty($shipping_address)) {
                $redirect = Url::link('checkout/checkout', '', 'SSL');
            }
            
            // Validate if shipping method has been set.
            if (!isset(Session::p()->data['shipping_method'])) {
                $redirect = Url::link('checkout/checkout', '', 'SSL');
            }
        } else {
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
        }
        
        // Validate if payment address has been set.
        Theme::model('account/address');
        
        if (Customer::isLogged() && isset(Session::p()->data['payment_address_id'])) {
            $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
        } elseif (isset(Session::p()->data['guest'])) {
            $payment_address = Session::p()->data['guest']['payment'];
        }
        
        // Validate if payment method has been set.
        if (!isset(Session::p()->data['payment_method'])) {
            $redirect = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $redirect = Url::link('checkout/cart');
        }
        
        // Validate minimum quantity requirements.
        $products = Cart::getProducts();
        
        foreach ($products as $product) {
            $product_total = 0;
            
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total+= $product_2['quantity'];
                }
            }
            
            if ($product['minimum'] > $product_total) {
                $redirect = Url::link('checkout/cart');
                
                break;
            }
        }
        
        if ($redirect == '') {
            $total_data = array();
            $total = 0;
            $taxes = Cart::getTaxes();
            
            Theme::model('setting/module');
            
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
            }
            
            $sort_order = array();
            
            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }
            
            array_multisort($sort_order, SORT_ASC, $total_data);
            
            $data = Theme::language('checkout/checkout', $data);
            
            $data['invoice_prefix'] = Config::get('config_invoice_prefix');
            $data['store_id']       = Config::get('config_store_id');
            $data['store_name']     = Config::get('config_name');
            
            if ($data['store_id']) {
                $data['store_url'] = Config::get('config_url');
            } else {
                $data['store_url'] = Config::get('http.server');
            }
            
            if (Customer::isLogged() && isset(Session::p()->data['payment_address_id'])) {
                $data['customer_id']       = Customer::getId();
                $data['customer_group_id'] = Customer::getGroupId();
                $data['firstname']         = Customer::getFirstName();
                $data['lastname']          = Customer::getLastName();
                $data['email']             = Customer::getEmail();
                $data['telephone']         = Customer::getTelephone();
                
                Theme::model('account/address');
                
                $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
            } elseif (isset(Session::p()->data['guest'])) {
                $data['customer_id']       = 0;
                $data['customer_group_id'] = Session::p()->data['guest']['customer_group_id'];
                $data['firstname']         = Session::p()->data['guest']['firstname'];
                $data['lastname']          = Session::p()->data['guest']['lastname'];
                $data['email']             = Session::p()->data['guest']['email'];
                $data['telephone']         = Session::p()->data['guest']['telephone'];
                
                $payment_address = Session::p()->data['guest']['payment'];
            }
            
            $data['payment_firstname']      = isset($payment_address['firstname']) ? $payment_address['firstname'] : '';
            $data['payment_lastname']       = isset($payment_address['lastname']) ? $payment_address['lastname'] : '';
            $data['payment_company']        = isset($payment_address['company']) ? $payment_address['company'] : '';
            $data['payment_company_id']     = isset($payment_address['company_id']) ? $payment_address['company_id'] : '';
            $data['payment_tax_id']         = isset($payment_address['tax_id']) ? $payment_address['tax_id'] : '';
            $data['payment_address_1']      = isset($payment_address['address_1']) ? $payment_address['address_1'] : '';
            $data['payment_address_2']      = isset($payment_address['address_2']) ? $payment_address['address_2'] : '';
            $data['payment_city']           = isset($payment_address['city']) ? $payment_address['city'] : '';
            $data['payment_postcode']       = isset($payment_address['postcode']) ? $payment_address['postcode'] : '';
            $data['payment_zone']           = isset($payment_address['zone']) ? $payment_address['zone'] : '';
            $data['payment_zone_id']        = isset($payment_address['zone_id']) ? $payment_address['zone_id'] : '';
            $data['payment_country']        = isset($payment_address['country']) ? $payment_address['country'] : '';
            $data['payment_country_id']     = isset($payment_address['country_id']) ? $payment_address['country_id'] : '';
            $data['payment_address_format'] = isset($payment_address['address_format']) ? $payment_address['address_format'] : '';
            
            $data['payment_method'] = '';
            if (isset(Session::p()->data['payment_method']['title'])) {
                $data['payment_method'] = Session::p()->data['payment_method']['title'];
            }
            
            $data['payment_code'] = '';
            if (isset(Session::p()->data['payment_method']['code'])) {
                $data['payment_code'] = Session::p()->data['payment_method']['code'];
            }
            
            if (Cart::hasShipping()) {
                if (Customer::isLogged()) {
                    Theme::model('account/address');
                    
                    $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
                } elseif (isset(Session::p()->data['guest'])) {
                    $shipping_address = Session::p()->data['guest']['shipping'];
                }
                
                $data['shipping_firstname']      = $shipping_address['firstname'];
                $data['shipping_lastname']       = $shipping_address['lastname'];
                $data['shipping_company']        = $shipping_address['company'];
                $data['shipping_address_1']      = $shipping_address['address_1'];
                $data['shipping_address_2']      = $shipping_address['address_2'];
                $data['shipping_city']           = $shipping_address['city'];
                $data['shipping_postcode']       = $shipping_address['postcode'];
                $data['shipping_zone']           = $shipping_address['zone'];
                $data['shipping_zone_id']        = $shipping_address['zone_id'];
                $data['shipping_country']        = $shipping_address['country'];
                $data['shipping_country_id']     = $shipping_address['country_id'];
                $data['shipping_address_format'] = $shipping_address['address_format'];
                
                $data['shipping_method'] = '';
                if (isset(Session::p()->data['shipping_method']['title'])) {
                    $data['shipping_method'] = Session::p()->data['shipping_method']['title'];
                }
                
                $data['shipping_code'] = '';
                if (isset(Session::p()->data['shipping_method']['code'])) {
                    $data['shipping_code'] = Session::p()->data['shipping_method']['code'];
                }
            } else {
                $data['shipping_firstname']      = '';
                $data['shipping_lastname']       = '';
                $data['shipping_company']        = '';
                $data['shipping_address_1']      = '';
                $data['shipping_address_2']      = '';
                $data['shipping_city']           = '';
                $data['shipping_postcode']       = '';
                $data['shipping_zone']           = '';
                $data['shipping_zone_id']        = '';
                $data['shipping_country']        = '';
                $data['shipping_country_id']     = '';
                $data['shipping_address_format'] = '';
                $data['shipping_method']         = '';
                $data['shipping_code']           = '';
            }
            
            $product_data = array();
            
            foreach (Cart::getProducts() as $product) {
                $option_data = array();
                
                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $value = $this->encryption->decrypt($option['option_value']);
                    }
                    
                    $option_data[] = array(
                        'product_option_id'       => $option['product_option_id'], 
                        'product_option_value_id' => $option['product_option_value_id'], 
                        'option_id'               => $option['option_id'], 
                        'option_value_id'         => $option['option_value_id'], 
                        'name'                    => $option['name'], 
                        'value'                   => $value, 
                        'type'                    => $option['type']
                    );
                }
                
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
            }
            
            // Gift Giftcard
            $gift_card_data = array();
            
            if (!empty(Session::p()->data['gift_cards'])) {
                foreach (Session::p()->data['gift_cards'] as $gift_card) {
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
                }
            }
            
            $data['products']  = $product_data;
            $data['gift_cards'] = $gift_card_data;
            $data['totals']    = $total_data;
            $data['comment']   = Session::p()->data['comment'];
            $data['total']     = $total;

            $sub_total = Cart::getSubTotal();
            
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
                $data['affiliate_id'] = $affiliate_id;
                $percent              = AccountAffiliate::getAffiliateCommission($affiliate_id);
                $commission           = $sub_total * ($percent / 100);
                $data['commission']   = number_format($commission, 2);
            else:
                $data['affiliate_id'] = 0;
                $data['commission']   = 0;
            endif;
            
            $data['language_id']    = Config::get('config_language_id');
            $data['currency_id']    = Currency::getId();
            $data['currency_code']  = Currency::getCode();
            $data['currency_value'] = Currency::getValue(Currency::getCode());
            $data['ip']             = Request::p()->server['REMOTE_ADDR'];
            
            if (!empty(Request::p()->server['HTTP_X_FORWARDED_FOR'])) {
                $data['forwarded_ip'] = Request::p()->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty(Request::p()->server['HTTP_CLIENT_IP'])) {
                $data['forwarded_ip'] = Request::p()->server['HTTP_CLIENT_IP'];
            } else {
                $data['forwarded_ip'] = '';
            }
            
            if (isset(Request::p()->server['HTTP_USER_AGENT'])) {
                $data['user_agent'] = Request::p()->server['HTTP_USER_AGENT'];
            } else {
                $data['user_agent'] = '';
            }
            
            if (isset(Request::p()->server['HTTP_ACCEPT_LANGUAGE'])) {
                $data['accept_language'] = Request::p()->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $data['accept_language'] = '';
            }
            
            Theme::model('checkout/order');
            
            $order_id = CheckoutOrder::addOrder($data);
            Session::p()->data['order_id'] = $order_id;
            
            Theme::model('payment/paypal_express');
            
            $paypal_data = array(
                'TOKEN'                      => Session::p()->data['paypal']['token'], 
                'PAYERID'                    => Session::p()->data['paypal']['payerid'], 
                'METHOD'                     => 'DoExpressCheckoutPayment', 
                'PAYMENTREQUEST_0_NOTIFYURL' => Url::link('payment/paypal_express/ipn', '', 'SSL'), 
                'RETURNFMFDETAILS'           => 1
            );
            
            $paypal_data = array_merge($paypal_data, PaymentPaypalExpress::paymentRequestInfo());
            
            $result = PaymentPaypalExpress::call($paypal_data);
            
            if ($result['ACK'] == 'Success') {
                
                //handle order status
                switch ($result['PAYMENTINFO_0_PAYMENTSTATUS']) {
                    case 'Canceled_Reversal':
                        $order_status_id = Config::get('paypal_express_canceled_reversal_status_id');
                        break;

                    case 'Completed':
                        $order_status_id = Config::get('paypal_express_completed_status_id');
                        break;

                    case 'Denied':
                        $order_status_id = Config::get('paypal_express_denied_status_id');
                        break;

                    case 'Expired':
                        $order_status_id = Config::get('paypal_express_expired_status_id');
                        break;

                    case 'Failed':
                        $order_status_id = Config::get('paypal_express_failed_status_id');
                        break;

                    case 'Pending':
                        $order_status_id = Config::get('paypal_express_pending_status_id');
                        break;

                    case 'Processed':
                        $order_status_id = Config::get('paypal_express_processed_status_id');
                        break;

                    case 'Refunded':
                        $order_status_id = Config::get('paypal_express_refunded_status_id');
                        break;

                    case 'Reversed':
                        $order_status_id = Config::get('paypal_express_reversed_status_id');
                        break;

                    case 'Voided':
                        $order_status_id = Config::get('paypal_express_voided_status_id');
                        break;
                }
                
                CheckoutOrder::confirm($order_id, $order_status_id);
                
                //add order to paypal table
                $paypal_order_data = array(
                    'order_id'         => $order_id, 
                    'capture_status'   => (Config::get('paypal_express_method') == 'Sale' ? 'Complete' : 'NotComplete'), 
                    'currency_code'    => $result['PAYMENTINFO_0_CURRENCYCODE'], 
                    'authorization_id' => $result['PAYMENTINFO_0_TRANSACTIONID'], 
                    'total'            => $result['PAYMENTINFO_0_AMT']
                );
                
                $paypal_order_id = PaymentPaypalExpress::addOrder($paypal_order_data);
                
                //add transaction to paypal transaction table
                $paypal_transaction_data = array(
                    'paypal_order_id'       => $paypal_order_id, 
                    'transaction_id'        => $result['PAYMENTINFO_0_TRANSACTIONID'], 
                    'parent_transaction_id' => '', 
                    'note'                  => '', 
                    'msgsubid'              => '', 
                    'receipt_id'            => (isset($result['PAYMENTINFO_0_RECEIPTID']) ? $result['PAYMENTINFO_0_RECEIPTID'] : ''), 
                    'payment_type'          => $result['PAYMENTINFO_0_PAYMENTTYPE'], 
                    'payment_status'        => $result['PAYMENTINFO_0_PAYMENTSTATUS'], 
                    'pending_reason'        => $result['PAYMENTINFO_0_PENDINGREASON'], 
                    'transaction_entity'    => (Config::get('paypal_express_method') == 'Sale' ? 'payment' : 'auth'), 
                    'amount'                => $result['PAYMENTINFO_0_AMT'], 
                    'debug_data'            => json_encode($result)
                );
                
                PaymentPaypalExpress::addTransaction($paypal_transaction_data);
                
                $recurring_products = Cart::getRecurringProducts();
                
                //loop through any products that are recurring items
                if ($recurring_products) {
                    Theme::language('payment/paypal_express');
                    
                    Theme::model('checkout/recurring');
                    
                    $billing_period = array(
                        'day'        => 'Day', 
                        'week'       => 'Week', 
                        'semi_month' => 'SemiMonth', 
                        'month'      => 'Month', 
                        'year'       => 'Year'
                    );
                    
                    foreach ($recurring_products as $item) {
                        $data = array(
                            'METHOD'             => 'CreateRecurringPaymentsProfile', 
                            'TOKEN'              => Session::p()->data['paypal']['token'], 
                            'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", mktime(gmdate("H"), gmdate("i") + 5, gmdate("s"), gmdate("m"), gmdate("d"), gmdate("y"))), 
                            'BILLINGPERIOD'      => $billing_period[$item['recurring']['frequency']], 
                            'BILLINGFREQUENCY'   => $item['recurring']['cycle'], 
                            'TOTALBILLINGCYCLES' => $item['recurring']['duration'], 
                            'AMT'                => Currency::format(Tax::calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'], 
                            'CURRENCYCODE'       => Currency::getCode()
                        );
                        
                        //trial information
                        if ($item['recurring']['trial']) {
                            $data_trial = array(
                                'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring']['trial_frequency']], 
                                'TRIALBILLINGFREQUENCY'   => $item['recurring']['trial_cycle'], 
                                'TRIALTOTALBILLINGCYCLES' => $item['recurring']['trial_duration'], 
                                'TRIALAMT'                => Currency::format(Tax::calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity']
                            );
                            
                            $trial_amt  = Currency::format(Tax::calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . Currency::getCode();
                            $trial_text = sprintf(Lang::get('lang_text_trial'), $trial_amt, $item['recurring']['trial_cycle'], $item['recurring']['trial_frequency'], $item['recurring']['trial_duration']);
                            
                            $data = array_merge($data, $data_trial);
                        } else {
                            $trial_text = '';
                        }
                        
                        $recurring_amt         = Currency::format(Tax::calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . Currency::getCode();
                        $recurring_description = $trial_text . sprintf(Lang::get('lang_text_recurring'), $recurring_amt, $item['recurring']['cycle'], $item['recurring']['frequency']);
                        
                        if ($item['recurring']['duration'] > 0) {
                            $recurring_description.= sprintf(Lang::get('lang_text_length'), $item['recurring']['duration']);
                        }
                        
                        //create new recurring and set to pending status as no payment has been made yet.
                        $recurring_id = CheckoutRecurring::create($item, $order_id, $recurring_description);
                        
                        $data['PROFILEREFERENCE'] = $recurring_id;
                        $data['DESC']             = $recurring_description;
                        
                        $result = PaymentPaypalExpress::call($data);
                        
                        if (isset($result['PROFILEID'])) {
                            CheckoutRecurring::addReference($recurring_id, $result['PROFILEID']);
                        } else {
                            
                            // there was an error creating the recurring, need to log and also alert admin / user
                            
                            
                        }
                    }
                }
                
                Response::redirect(Url::link('checkout/success'));
                
                if (isset($result['REDIRECTREQUIRED']) && $result['REDIRECTREQUIRED'] === true) {
                    
                    //- handle german redirect here
                    Response::redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . Session::p()->data['paypal']['token']);
                }
            } else {
                if ($result['L_ERRORCODE0'] == '10486') {
                    if (isset(Session::p()->data['paypal_redirect_count'])) {
                        
                        if (Session::p()->data['paypal_redirect_count'] == 2) {
                            Session::p()->data['paypal_redirect_count'] = 0;
                            Session::p()->data['error'] = Lang::get('lang_error_too_many_failures');
                            Response::redirect(Url::link('checkout/checkout', '', 'SSL'));
                        } else {
                            Session::p()->data['paypal_redirect_count']++;
                        }
                    } else {
                        Session::p()->data['paypal_redirect_count'] = 1;
                    }
                    
                    if (Config::get('paypal_express_test') == 1) {
                        Response::redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . Session::p()->data['paypal']['token']);
                    } else {
                        Response::redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . Session::p()->data['paypal']['token']);
                    }
                }
                
                Session::p()->data['error'] = $result['L_LONGMESSAGE0'];
                Response::redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
            }
        } else {
            Response::redirect($redirect);
        }
    }
    
    public function checkout() {
        if ((!Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            Response::redirect(Url::link('checkout/cart'));
        }
        
        Theme::model('payment/paypal_express');
        Theme::model('tool/image');
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder(Session::p()->data['order_id']);
        
        $max_amount = Currency::convert($order_info['total'], Config::get('config_currency'), 'USD');
        $max_amount = min($max_amount * 1.25, 10000);
        $max_amount = Currency::format($max_amount, Currency::getCode(), '', false);
        
        $data = array(
            'METHOD'             => 'SetExpressCheckout', 
            'MAXAMT'             => $max_amount, 
            'RETURNURL'          => Url::link('payment/paypal_express/checkoutReturn', '', 'SSL'), 
            'CANCELURL'          => Url::link('checkout/checkout', '', 'SSL'), 
            'REQCONFIRMSHIPPING' => 0, 
            'NOSHIPPING'         => 1, 
            'LOCALECODE'         => 'EN', 
            'LANDINGPAGE'        => 'Login', 
            'HDRIMG'             => ToolImage::resize(Config::get('paypal_express_logo'), 790, 90), 
            'PAYFLOWCOLOR'       => Config::get('paypal_express_page_colour'), 
            'CHANNELTYPE'        => 'Merchant', 
            'ALLOWNOTE'          => Config::get('paypal_express_allow_note')
        );
        
        if (isset(Session::p()->data['paypal_express_login']['seamless']['access_token']) && (isset(Session::p()->data['paypal_express_login']['seamless']['customer_id']) && Session::p()->data['paypal_express_login']['seamless']['customer_id'] == Customer::getId()) && Config::get('paypal_express_login_seamless')) {
            $data['IDENTITYACCESSTOKEN'] = Session::p()->data['paypal_express_login']['seamless']['access_token'];
        }
        
        $data = array_merge($data, PaymentPaypalExpress::paymentRequestInfo());
        
        $result = PaymentPaypalExpress::call($data);
        
        /**
         * If a failed PayPal setup happens, handle it.
         */
        if (!isset($result['TOKEN'])) {
            Session::p()->data['error'] = $result['L_LONGMESSAGE0'];
            
            /**
             * Unable to add error message to user as the session errors/success are not
             * used on the cart or checkout pages - need to be added?
             * If PayPal debug log is off then still log error to normal error log.
             */
            if (Config::get('paypal_express_debug') == 1) {
                $this->log->write(serialize($result));
            }
            
            Response::redirect(Url::link('checkout/checkout', '', 'SSL'));
        }
        
        Session::p()->data['paypal']['token'] = $result['TOKEN'];
        
        if (Config::get('paypal_express_test') == 1) {
            header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'] . '&useraction=commit');
        } else {
            header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'] . '&useraction=commit');
        }
    }
    
    public function checkoutReturn() {
        $data = Theme::language('payment/paypal_express');
        
        /**
         * Get the details
         */
        Theme::model('payment/paypal_express');
        Theme::model('checkout/order');
        
        $data = array('METHOD' => 'GetExpressCheckoutDetails', 'TOKEN' => Session::p()->data['paypal']['token']);
        
        $result = PaymentPaypalExpress::call($data);
        
        Session::p()->data['paypal']['payerid'] = $result['PAYERID'];
        Session::p()->data['paypal']['result'] = $result;
        
        $order_id = Session::p()->data['order_id'];
        
        $paypal_data = array(
            'TOKEN'                      => Session::p()->data['paypal']['token'], 
            'PAYERID'                    => Session::p()->data['paypal']['payerid'], 
            'METHOD'                     => 'DoExpressCheckoutPayment', 
            'PAYMENTREQUEST_0_NOTIFYURL' => Url::link('payment/paypal_express/ipn', '', 'SSL'), 
            'RETURNFMFDETAILS'           => 1
        );
        
        $paypal_data = array_merge($paypal_data, PaymentPaypalExpress::paymentRequestInfo());
        
        $result = PaymentPaypalExpress::call($paypal_data);
        
        if ($result['ACK'] == 'Success') {
            
            //handle order status
            switch ($result['PAYMENTINFO_0_PAYMENTSTATUS']) {
                case 'Canceled_Reversal':
                    $order_status_id = Config::get('paypal_express_canceled_reversal_status_id');
                    break;

                case 'Completed':
                    $order_status_id = Config::get('paypal_express_completed_status_id');
                    break;

                case 'Denied':
                    $order_status_id = Config::get('paypal_express_denied_status_id');
                    break;

                case 'Expired':
                    $order_status_id = Config::get('paypal_express_expired_status_id');
                    break;

                case 'Failed':
                    $order_status_id = Config::get('paypal_express_failed_status_id');
                    break;

                case 'Pending':
                    $order_status_id = Config::get('paypal_express_pending_status_id');
                    break;

                case 'Processed':
                    $order_status_id = Config::get('paypal_express_processed_status_id');
                    break;

                case 'Refunded':
                    $order_status_id = Config::get('paypal_express_refunded_status_id');
                    break;

                case 'Reversed':
                    $order_status_id = Config::get('paypal_express_reversed_status_id');
                    break;

                case 'Voided':
                    $order_status_id = Config::get('paypal_express_voided_status_id');
                    break;
            }
            
            CheckoutOrder::confirm($order_id, $order_status_id);
            
            //add order to paypal table
            $paypal_order_data = array(
                'order_id'         => $order_id, 
                'capture_status'   => (Config::get('paypal_express_method') == 'Sale' ? 'Complete' : 'NotComplete'), 
                'currency_code'    => $result['PAYMENTINFO_0_CURRENCYCODE'], 
                'authorization_id' => $result['PAYMENTINFO_0_TRANSACTIONID'], 
                'total'            => $result['PAYMENTINFO_0_AMT']
            );
            
            $paypal_order_id = PaymentPaypalExpress::addOrder($paypal_order_data);
            
            //add transaction to paypal transaction table
            $paypal_transaction_data = array(
                'paypal_order_id'       => $paypal_order_id, 
                'transaction_id'        => $result['PAYMENTINFO_0_TRANSACTIONID'], 
                'parent_transaction_id' => '', 
                'note'                  => '', 
                'msgsubid'              => '', 
                'receipt_id'            => (isset($result['PAYMENTINFO_0_RECEIPTID']) ? $result['PAYMENTINFO_0_RECEIPTID'] : ''), 
                'payment_type'          => $result['PAYMENTINFO_0_PAYMENTTYPE'], 
                'payment_status'        => $result['PAYMENTINFO_0_PAYMENTSTATUS'], 
                'pending_reason'        => $result['PAYMENTINFO_0_PENDINGREASON'], 
                'transaction_entity'    => (Config::get('paypal_express_method') == 'Sale' ? 'payment' : 'auth'), 
                'amount'                => $result['PAYMENTINFO_0_AMT'], 
                'debug_data'            => json_encode($result)
            );

            PaymentPaypalExpress::addTransaction($paypal_transaction_data);
            
            $recurring_products = Cart::getRecurringProducts();
            
            //loop through any products that are recurring items
            if ($recurring_products) {
                Theme::model('checkout/recurring');
                
                $billing_period = array(
                    'day'        => 'Day', 
                    'week'       => 'Week', 
                    'semi_month' => 'SemiMonth', 
                    'month'      => 'Month', 
                    'year'       => 'Year'
                );
                
                foreach ($recurring_products as $item) {
                    $data = array(
                        'METHOD'             => 'CreateRecurringPaymentsProfile', 
                        'TOKEN'              => Session::p()->data['paypal']['token'], 
                        'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", mktime(gmdate('H'), gmdate('i') + 5, gmdate('s'), gmdate('m'), gmdate('d'), gmdate('y'))), 
                        'BILLINGPERIOD'      => $billing_period[$item['recurring']['frequency']], 
                        'BILLINGFREQUENCY'   => $item['recurring']['cycle'], 
                        'TOTALBILLINGCYCLES' => $item['recurring']['duration'], 
                        'AMT'                => Currency::format(Tax::calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'], 
                        'CURRENCYCODE'       => Currency::getCode()
                    );
                    
                    //trial information
                    if ($item['recurring']['trial'] == 1) {
                        $data_trial = array(
                            'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring']['trial_frequency']], 
                            'TRIALBILLINGFREQUENCY'   => $item['recurring']['trial_cycle'], 
                            'TRIALTOTALBILLINGCYCLES' => $item['recurring']['trial_duration'], 
                            'TRIALAMT'                => Currency::format(Tax::calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity']
                        );
                        
                        $trial_amt = Currency::format(Tax::calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . Currency::getCode();
                        $trial_text = sprintf(Lang::get('lang_text_trial'), $trial_amt, $item['recurring']['trial_cycle'], $item['recurring']['trial_frequency'], $item['recurring']['trial_duration']);
                        
                        $data = array_merge($data, $data_trial);
                    } else {
                        $trial_text = '';
                    }
                    
                    $recurring_amt         = Currency::format(Tax::calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . Currency::getCode();
                    $recurring_description = $trial_text . sprintf(Lang::get('lang_text_recurring'), $recurring_amt, $item['recurring']['cycle'], $item['recurring']['frequency']);
                    
                    if ($item['recurring']['duration'] > 0) {
                        $recurring_description.= sprintf(Lang::get('lang_text_length'), $item['recurring']['duration']);
                    }
                    
                    //create new recurring and set to pending status as no payment has been made yet.
                    $recurring_id = CheckoutRecurring::create($item, $order_id, $recurring_description);
                    
                    $data['PROFILEREFERENCE'] = $recurring_id;
                    $data['DESC']             = $recurring_description;
                    
                    $result = PaymentPaypalExpress::call($data);
                    
                    if (isset($result['PROFILEID'])) {
                        CheckoutRecurring::addReference($recurring_id, $result['PROFILEID']);
                    } else {
                        
                        // there was an error creating the recurring, need to log and also alert admin / user
                        
                        
                    }
                }
            }
            
            if (isset($result['REDIRECTREQUIRED']) && $result['REDIRECTREQUIRED'] === true) {
                
                //- handle german redirect here
                Response::redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . Session::p()->data['paypal']['token']);
            } else {
                Response::redirect(Url::link('checkout/success'));
            }
        } else {
            
            if ($result['L_ERRORCODE0'] == '10486') {
                if (isset(Session::p()->data['paypal_redirect_count'])) {
                    
                    if (Session::p()->data['paypal_redirect_count'] == 2) {
                        Session::p()->data['paypal_redirect_count'] = 0;
                        Session::p()->data['error'] = Lang::get('lang_error_too_many_failures');
                        
                        Response::redirect(Url::link('checkout/checkout', '', 'SSL'));
                    } else {
                        Session::p()->data['paypal_redirect_count']++;
                    }
                } else {
                    Session::p()->data['paypal_redirect_count'] = 1;
                }
                
                if (Config::get('paypal_express_test') == 1) {
                    Response::redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . Session::p()->data['paypal']['token']);
                } else {
                    Response::redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . Session::p()->data['paypal']['token']);
                }
            }
            
            Breadcrumb::add('lang_text_cart', 'checkout/cart', '', true, 'SSL');
            
            $data['heading_title'] = Lang::get('lang_error_heading_title');
            
            $data['text_error'] = '<div class="alert alert-danger">' . $result['L_ERRORCODE0'] . ' : ' . $result['L_LONGMESSAGE0'] . '</div>';
            
            $data['continue'] = Url::link('checkout/cart', '', 'SSL');
            
            unset(Session::p()->data['success']);
            
            Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . ' 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('error/not_found', $data));
        }
    }
    
    public function ipn() {
        Theme::model('payment/paypal_express');
        Theme::model('payment/express_ipn');
        Theme::model('account/recurring');
        
        $request = 'cmd=_notify-validate';
        
        if (Config::get('paypal_express_test') == 1) {
            $curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
        } else {
            $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
        }
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = trim(curl_exec($curl));
        
        if (!$response) {
            PaymentPaypalExpress::log(array(
                    'error'    => curl_error($curl), 
                    'error_no' => curl_errno($curl)
                ), 'Curl failed'
            );
        }
        
        PaymentPaypalExpress::log(array(
                'request'  => $request, 
                'response' => $response
            ), 'IPN data'
        );
        
        if ((string)$response == "VERIFIED") {
            
            if (Config::get('paypal_express_debug') == 1) {
                if (isset(Request::p()->post['transaction_entity'])) $this->log->write(Request::p()->post['transaction_entity']);
            }
            
            if (isset(Request::p()->post['txn_id'])) {
                $transaction = PaymentPaypalExpress::getTransactionRow(Request::p()->post['txn_id']);
            } else {
                $transaction = false;
            }
            
            if ($transaction) {
                
                //transaction exists, check for cleared payment or updates etc
                if (Config::get('paypal_express_debug') == 1) $this->log->write('Transaction exists');
                
                //if the transaction is pending but the new status is completed
                if ($transaction['payment_status'] != Request::p()->post['payment_status']) {
                    PaymentExpressIpn::updateStatus(Request::p()->post['payment_status'], $transaction['transaction_id']);
                } elseif ($transaction['payment_status'] == 'Pending' && ($transaction['pending_reason'] != Request::p()->post['pending_reason'])) {
                    PaymentExpressIpn::updatePending(Request::p()->post['pending_reason'], $transaction['transaction_id']);
                }
            } else {
                if (Config::get('paypal_express_debug') == 1) $this->log->write('Transaction does not exist');
                
                $parent_transaction = false;
                
                if (isset(Request::p()->post['parent_txn_id'])) {
                    $parent_transaction = PaymentPaypalExpress::getTransactionRow(Request::p()->post['parent_txn_id']);
                } else {
                    $parent_transaction = PaymentPaypalExpress::getTransactionRowByReference(Request::p()->post['recurring_payment_id']);
                }
                
                if ($parent_transaction) {
                    if (Config::get('paypal_express_debug') == 1) $this->log->write('Parent transaction exists');
                    
                    //parent transaction exists
                    //add new related transaction
                    $transaction = array(
                        'paypal_order_id'       => $parent_transaction['paypal_order_id'], 
                        'transaction_id'        => Request::p()->post['txn_id'], 
                        'parent_transaction_id' => $parent_transaction['transaction_id'], 
                        'note'                  => '', 
                        'msgsubid'              => '', 
                        'receipt_id'            => (isset(Request::p()->post['receipt_id']) ? Request::p()->post['receipt_id'] : ''), 
                        'payment_type'          => (isset(Request::p()->post['payment_type']) ? Request::p()->post['payment_type'] : ''), 
                        'payment_status'        => (isset(Request::p()->post['payment_status']) ? Request::p()->post['payment_status'] : ''), 
                        'pending_reason'        => (isset(Request::p()->post['pending_reason']) ? Request::p()->post['pending_reason'] : ''), 
                        'amount'                => Request::p()->post['mc_gross'], 
                        'debug_data'            => json_encode(Request::post()), 
                        'transaction_entity'    => (isset(Request::p()->post['transaction_entity']) ? Request::p()->post['transaction_entity'] : '')
                    );
                    
                    PaymentPaypalExpress::addTransaction($transaction);
                    
                    /**
                     * If there has been a refund, log this against the parent transaction.
                     */
                    if (isset(Request::p()->post['payment_status']) && Request::p()->post['payment_status'] == 'Refunded') {
                        PaymentExpressIpn::processRefund(Request::p()->post['mc_gross'], $parent_transaction['amount'], $parent_transaction['transaction_id']);
                    }
                    
                    /**
                     * If the capture payment is now complete
                     */
                    if (isset(Request::p()->post['auth_status']) && Request::p()->post['auth_status'] == 'Completed' && $parent_transaction['payment_status'] == 'Pending') {
                        $captured  = Currency::format(PaymentPaypalExpress::totalCaptured($parent_transaction['paypal_order_id']), false, false, false);
                        $refunded  = Currency::format(PaymentPaypalExpress::totalRefundedOrder($parent_transaction['paypal_order_id']), false, false, false);
                        $remaining = Currency::format($parent_transaction['amount'] - $captured + $refunded, false, false, false);
                        
                        if (Config::get('paypal_express_debug') == 1) {
                            $this->log->write('Captured: ' . $captured);
                            $this->log->write('Refunded: ' . $refunded);
                            $this->log->write('Remaining: ' . $remaining);
                        }
                        
                        if ($remaining > 0.00) {
                            $transaction = array(
                                'paypal_order_id'       => $parent_transaction['paypal_order_id'], 
                                'transaction_id'        => '', 
                                'parent_transaction_id' => $parent_transaction['transaction_id'], 
                                'note'                  => '', 
                                'msgsubid'              => '', 
                                'receipt_id'            => '', 
                                'payment_type'          => '', 
                                'payment_status'        => 'Void', 
                                'pending_reason'        => '', 
                                'amount'                => '', 
                                'debug_data'            => 'Voided after capture', 
                                'transaction_entity'    => 'auth'
                            );
                            
                            PaymentPaypalExpress::addTransaction($transaction);
                        }
                        
                        PaymentPaypalExpress::updateOrder('Complete', $parent_transaction['order_id']);
                    }
                } else {
                    
                    //parent transaction doesn't exists, need to investigate?
                    if (Config::get('paypal_express_debug') == 1) $this->log->write('Parent transaction not found');
                }
            }
            
            /*
             * Subscription payments
             *
             * recurring ID should always exist if its a recurring payment transaction.
             *
             * also the reference will match a recurring payment ID
            */
            
            if (isset(Request::p()->post['txn_type'])) {
                
                //payment
                if (Request::p()->post['txn_type'] == 'recurring_payment') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::processPayment($recur['order_recurring_id'], Request::p()->post['amount'], $recur['status']);
                    }
                }
                
                //suspend
                if (Request::p()->post['txn_type'] == 'recurring_payment_suspended') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::processSuspend($recur['order_recurring_id']);
                    }
                }
                
                //suspend due to max failed
                if (Request::p()->post['txn_type'] == 'recurring_payment_suspended_due_to_max_failed_payment') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::suspendMaxFailed($recur['order_recurring_id']);
                    }
                }
                
                //payment failed
                if (Request::p()->post['txn_type'] == 'recurring_payment_failed') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::paymentFailed($recur['order_recurring_id']);
                    }
                }
                
                //outstanding payment failed
                if (Request::p()->post['txn_type'] == 'recurring_payment_outstanding_payment_failed') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::outstandingPaymentFailed($recur['order_recurring_id']);
                    }
                }
                
                //outstanding payment
                if (Request::p()->post['txn_type'] == 'recurring_payment_outstanding_payment') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::outstandingPayment($recur['order_recurring_id'], Request::p()->post['amount'], $recur['status']);
                    }
                }
                
                //date_added
                if (Request::p()->post['txn_type'] == 'recurring_payment_recurring_date_added') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::dateAdded($recur['order_recurring_id'], $recur['status']);
                    }
                }
                
                //canceled
                if (Request::p()->post['txn_type'] == 'recurring_payment_recurring_cancel') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false && $recur['status'] != 3) {
                        PaymentExpressIpn::processCanceled($recur['order_recurring_id']);
                    }
                }
                
                //skipped
                if (Request::p()->post['txn_type'] == 'recurring_payment_skipped') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::processSkipped($recur['order_recurring_id']);
                    }
                }
                
                //expired
                if (Request::p()->post['txn_type'] == 'recurring_payment_expired') {
                    $recur = AccountRecurring::getRecurringByRef(Request::p()->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        PaymentExpressIpn::processExpired($recur['order_recurring_id']);
                    }
                }
            }
        } elseif ((string)$response == "INVALID") {
            PaymentPaypalExpress::log(array('IPN was invalid'), 'IPN fail');
        } else {
            if (Config::get('paypal_express_debug') == 1) {
                $this->log->write('string unknown ');
            }
        }
        
        header("HTTP/1.1 200 Ok");
    }
    
    public function shipping() {
        $this->shippingValidate(Request::p()->post['shipping_method']);
        
        Response::redirect(Url::link('payment/paypal_express/expressConfirm'));
    }
    
    protected function shippingValidate($code) {
        Theme::language('checkout/cart');
        Theme::language('payment/paypal_express');
        
        if (empty($code)) {
            Session::p()->data['error_warning'] = Lang::get('lang_error_shipping');
            return false;
        } else {
            $shipping = explode('.', $code);
            
            if (!isset($shipping[0]) || !isset($shipping[1]) || !isset(Session::p()->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                Session::p()->data['error_warning'] = Lang::get('lang_error_shipping');
                return false;
            } else {
                Session::p()->data['shipping_method'] = Session::p()->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
                Session::p()->data['success'] = Lang::get('lang_text_shipping_updated');
                return true;
            }
        }
    }
    
    public function recurringCancel() {
        
        //cancel an active recurring
        
        Theme::model('account/recurring');
        Theme::model('payment/paypal_express');
        Theme::language('account/recurring');
        
        $recur = AccountRecurring::getRecurring(Request::p()->get['recurring_id']);
        
        if ($recur && !empty($recur['reference'])) {
            
            $result = PaymentPaypalExpress::recurringCancel($recur['reference']);
            
            if (isset($result['PROFILEID'])) {
                $this->db->query("
					INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
					SET 
						`order_recurring_id` = '" . (int)$recur['order_recurring_id'] . "', 
						`date_added` = NOW(), 
						`type` = '5'");
                
                $this->db->query("
					UPDATE `{$this->db->prefix}order_recurring` 
					SET 
						`status` = 4 
					WHERE `order_recurring_id` = '" . (int)$recur['order_recurring_id'] . "' 
					LIMIT 1");
                
                Session::p()->data['success'] = Lang::get('lang_text_cancelled');
            } else {
                Session::p()->data['error'] = sprintf(Lang::get('lang_error_not_cancelled'), $result['L_LONGMESSAGE0']);
            }
        } else {
            Session::p()->data['error'] = Lang::get('lang_error_not_found');
        }
        
        Response::redirect(Url::link('account/recurring/info', 'recurring_id=' . Request::p()->get['recurring_id'], 'SSL'));
    }
    
    protected function validateCoupon() {
        Theme::model('checkout/coupon');
        
        $coupon_info = CheckoutCoupon::getCoupon(Request::p()->post['coupon']);
        
        $error = '';
        
        if (!$coupon_info) {
            $error = Lang::get('lang_error_coupon');
        }
        
        if (!$error) {
            return true;
        } else {
            Session::p()->data['error_warning'] = $error;
            return false;
        }
    }
    
    protected function validateGiftcard() {
        Theme::model('checkout/gift_card');
        
        $gift_card_info = CheckoutGiftCard::getGiftcard(Request::p()->post['gift_card']);
        
        $error = '';
        
        if (!$gift_card_info) {
            $error = Lang::get('lang_error_gift_card');
        }
        
        if (!$error) {
            return true;
        } else {
            Session::p()->data['error_warning'] = Lang::get('lang_error_gift_card');;
            return false;
        }
    }
    
    protected function validateReward() {
        $points = Customer::getRewardPoints();
        
        $points_total = 0;
        
        foreach (Cart::getProducts() as $product) {
            if ($product['points']) {
                $points_total+= $product['points'];
            }
        }
        
        $error = '';
        
        if (empty(Request::p()->post['reward'])) {
            $error = Lang::get('lang_error_reward');
        }
        
        if (Request::p()->post['reward'] > $points) {
            $error = sprintf(Lang::get('lang_error_points'), Request::p()->post['reward']);
        }
        
        if (Request::p()->post['reward'] > $points_total) {
            $error = sprintf(Lang::get('lang_error_maximum'), $points_total);
        }
        
        if (!$error) {
            return true;
        } else {
            Session::p()->data['error_warning'] = $error;
            return false;
        }
    }
    
    public function recurringButtons() {
        $data = Theme::language('payment/paypal_express');
        
        $recur = AccountRecurring::getRecurring(Request::p()->get['recurring_id']);
        
        $data['buttons'] = array();
        
        if ($recur['status'] == 2 || $recur['status'] == 3) {
            $data['buttons'][] = array(
                'text' => Lang::get('lang_button_cancel_recurring'), 
                'link' => Url::link('payment/paypal_express/recurringCancel', 'recurring_id=' . Request::p()->get['recurring_id'], 'SSL')
            );
        }
        
        $data['buttons'][] = array(
            'text' => Lang::get('lang_button_continue'), 
            'link' => Url::link('account/recurring', '', 'SSL')
        );
        
        return View::make('common/buttons', $data);
    }
}
