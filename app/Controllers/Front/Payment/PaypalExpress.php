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
        unset($this->session->data['paypal']);
        
        Theme::loadjs('javascript/payment/paypal_express', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return Theme::view('payment/paypal_express', $data);
    }
    
    public function express() {
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !Config::get('config_stock_checkout'))) {
            $this->log->write('No product redirect');
            $this->response->redirect(Url::link('checkout/cart'));
        }
        
        if ($this->customer->isLogged()) {
            
            /**
             * If the customer is already logged in
             */
            $this->session->data['paypal']['guest'] = false;
            unset($this->session->data['guest']);
        } else {
            if (Config::get('config_checkout_guest') && !Config::get('config_customer_price') && !$this->cart->hasDownload() && !$this->cart->hasRecurringProducts()) {
                
                /**
                 * If the guest checkout is allowed (config ok, no login for price and doesn't have downloads)
                 */
                $this->session->data['paypal']['guest'] = true;
            } else {
                
                /**
                 * If guest checkout disabled or login is required before price or order has downloads
                 *
                 * Send them to the normal checkout flow.
                 */
                unset($this->session->data['guest']);
                $this->response->redirect(Url::link('checkout/checkout', '', 'SSL'));
            }
        }
        
        unset($this->session->data['shipping_method']);
        unset($this->session->data['shipping_methods']);
        unset($this->session->data['payment_method']);
        unset($this->session->data['payment_methods']);
        
        Theme::model('payment/paypal_express');
        Theme::model('tool/image');
        
        if ($this->cart->hasShipping()) {
            $shipping = 2;
        } else {
            $shipping = 1;
        }
        
        $max_amount = $this->currency->convert($this->cart->getTotal(), Config::get('config_currency'), 'USD');
        $max_amount = min($max_amount * 1.5, 10000);
        $max_amount = $this->currency->format($max_amount, $this->currency->getCode(), '', false);
        
        $data = array(
            'METHOD'             => 'SetExpressCheckout', 
            'MAXAMT'             => $max_amount, 
            'RETURNURL'          => Url::link('payment/paypal_express/expressReturn', '', 'SSL'), 
            'CANCELURL'          => Url::link('checkout/cart', '', 'SSL'), 
            'REQCONFIRMSHIPPING' => 0, 
            'NOSHIPPING'         => $shipping, 
            'ALLOWNOTE'          => Config::get('paypalexpress_allow_note'), 
            'LOCALECODE'         => 'EN', 
            'LANDINGPAGE'        => 'Login', 
            'HDRIMG'             => $this->model_tool_image->resize(Config::get('paypalexpress_logo'), 790, 90), 
            'PAYFLOWCOLOR'       => Config::get('paypalexpress_page_colour'), 
            'CHANNELTYPE'        => 'Merchant'
        );
        
        if (isset($this->session->data['paypalexpress_login']['seamless']['access_token']) && (isset($this->session->data['paypalexpress_login']['seamless']['customer_id']) && $this->session->data['paypalexpress_login']['seamless']['customer_id'] == $this->customer->getId()) && Config::get('paypalexpress_login_seamless')) {
            $data['IDENTITYACCESSTOKEN'] = $this->session->data['paypalexpress_login']['seamless']['access_token'];
        }
        
        $data = array_merge($data, $this->model_payment_paypal_express->paymentRequestInfo());
        
        $result = $this->model_payment_paypal_express->call($data);
        
        /**
         * If a failed PayPal setup happens, handle it.
         */
        if (!isset($result['TOKEN'])) {
            $this->session->data['error'] = $result['L_LONGMESSAGE0'];
            
            /**
             * Unable to add error message to user as the session errors/success are not
             * used on the cart or checkout pages - need to be added?
             * If PayPal debug log is off then still log error to normal error log.
             */
            if (Config::get('paypalexpress_debug') == 1) {
                $this->log->write(serialize($result));
            }
            
            $this->response->redirect(Url::link('checkout/checkout', '', 'SSL'));
        }
        
        $this->session->data['paypal']['token'] = $result['TOKEN'];
        
        if (Config::get('paypalexpress_test') == 1) {
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
            'TOKEN'  => $this->session->data['paypal']['token']
        );
        
        $result = $this->model_payment_paypal_express->call($data);
        $this->session->data['paypal']['payerid'] = $result['PAYERID'];
        $this->session->data['paypal']['result']  = $result;
        
        $this->session->data['comment'] = '';
        if (isset($result['PAYMENTREQUEST_0_NOTETEXT'])) {
            $this->session->data['comment'] = $result['PAYMENTREQUEST_0_NOTETEXT'];
        }
        
        if ($this->session->data['paypal']['guest'] === true) {
            
            $this->session->data['guest']['customer_group_id'] = Config::get('config_default_visibility');
            $this->session->data['guest']['firstname']         = trim($result['FIRSTNAME']);
            $this->session->data['guest']['lastname']          = trim($result['LASTNAME']);
            $this->session->data['guest']['email']             = trim($result['EMAIL']);

            if (isset($result['PHONENUM'])) {
                $this->session->data['guest']['telephone'] = $result['PHONENUM'];
            } else {
                $this->session->data['guest']['telephone'] = '';
            }
            
            $this->session->data['guest']['payment']['firstname'] = trim($result['FIRSTNAME']);
            $this->session->data['guest']['payment']['lastname']  = trim($result['LASTNAME']);
            
            if (isset($result['BUSINESS'])) {
                $this->session->data['guest']['payment']['company'] = $result['BUSINESS'];
            } else {
                $this->session->data['guest']['payment']['company'] = '';
            }
            
            $this->session->data['guest']['payment']['company_id'] = '';
            $this->session->data['guest']['payment']['tax_id']     = '';
            
            if ($this->cart->hasShipping()) {
                $shipping_name       = explode(' ', trim($result['PAYMENTREQUEST_0_SHIPTONAME']));
                $shipping_first_name = $shipping_name[0];
                unset($shipping_name[0]);
                $shipping_last_name  = implode(' ', $shipping_name);
                
                $this->session->data['guest']['payment']['address_1'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET'];
                
                if (isset($result['PAYMENTREQUEST_0_SHIPTOSTREET2'])) {
                    $this->session->data['guest']['payment']['address_2'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET2'];
                } else {
                    $this->session->data['guest']['payment']['address_2'] = '';
                }
                
                $this->session->data['guest']['payment']['postcode']   = $result['PAYMENTREQUEST_0_SHIPTOZIP'];
                $this->session->data['guest']['payment']['city']       = $result['PAYMENTREQUEST_0_SHIPTOCITY'];
                
                $this->session->data['guest']['shipping']['firstname'] = $shipping_first_name;
                $this->session->data['guest']['shipping']['lastname']  = $shipping_last_name;
                $this->session->data['guest']['shipping']['company']   = '';
                $this->session->data['guest']['shipping']['address_1'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET'];
                
                if (isset($result['PAYMENTREQUEST_0_SHIPTOSTREET2'])) {
                    $this->session->data['guest']['shipping']['address_2'] = $result['PAYMENTREQUEST_0_SHIPTOSTREET2'];
                } else {
                    $this->session->data['guest']['shipping']['address_2'] = '';
                }
                
                $this->session->data['guest']['shipping']['postcode'] = $result['PAYMENTREQUEST_0_SHIPTOZIP'];
                $this->session->data['guest']['shipping']['city']     = $result['PAYMENTREQUEST_0_SHIPTOCITY'];
                
                $this->session->data['shipping_postcode']             = $result['PAYMENTREQUEST_0_SHIPTOZIP'];
                
                $country_info = $this->db->query("
					SELECT * 
					FROM `{$this->db->prefix}country` 
					WHERE `iso_code_2` = '" . $this->db->escape($result['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) . "' 
					AND `status` = '1' 
					LIMIT 1")->row;
                
                if ($country_info) {
                    $this->session->data['guest']['shipping']['country_id']     = $country_info['country_id'];
                    $this->session->data['guest']['shipping']['country']        = $country_info['name'];
                    $this->session->data['guest']['shipping']['iso_code_2']     = $country_info['iso_code_2'];
                    $this->session->data['guest']['shipping']['iso_code_3']     = $country_info['iso_code_3'];
                    $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
                    $this->session->data['guest']['payment']['country_id']      = $country_info['country_id'];
                    $this->session->data['guest']['payment']['country']         = $country_info['name'];
                    $this->session->data['guest']['payment']['iso_code_2']      = $country_info['iso_code_2'];
                    $this->session->data['guest']['payment']['iso_code_3']      = $country_info['iso_code_3'];
                    $this->session->data['guest']['payment']['address_format']  = $country_info['address_format'];
                    $this->session->data['shipping_country_id']                 = $country_info['country_id'];
                } else {
                    $this->session->data['guest']['shipping']['country_id']     = '';
                    $this->session->data['guest']['shipping']['country']        = '';
                    $this->session->data['guest']['shipping']['iso_code_2']     = '';
                    $this->session->data['guest']['shipping']['iso_code_3']     = '';
                    $this->session->data['guest']['shipping']['address_format'] = '';
                    $this->session->data['guest']['payment']['country_id']      = '';
                    $this->session->data['guest']['payment']['country']         = '';
                    $this->session->data['guest']['payment']['iso_code_2']      = '';
                    $this->session->data['guest']['payment']['iso_code_3']      = '';
                    $this->session->data['guest']['payment']['address_format']  = '';
                    $this->session->data['shipping_country_id']                 = '';
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
                    $this->session->data['guest']['shipping']['zone']      = $zone_info['name'];
                    $this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
                    $this->session->data['guest']['shipping']['zone_id']   = $zone_info['zone_id'];
                    $this->session->data['guest']['payment']['zone']       = $zone_info['name'];
                    $this->session->data['guest']['payment']['zone_code']  = $zone_info['code'];
                    $this->session->data['guest']['payment']['zone_id']    = $zone_info['zone_id'];
                    $this->session->data['shipping_zone_id']               = $zone_info['zone_id'];
                } else {
                    $this->session->data['guest']['shipping']['zone']      = '';
                    $this->session->data['guest']['shipping']['zone_code'] = '';
                    $this->session->data['guest']['shipping']['zone_id']   = '';
                    $this->session->data['guest']['payment']['zone']       = '';
                    $this->session->data['guest']['payment']['zone_code']  = '';
                    $this->session->data['guest']['payment']['zone_id']    = '';
                    $this->session->data['shipping_zone_id']               = '';
                }
                
                $this->session->data['guest']['shipping_address'] = true;
            } else {
                $this->session->data['guest']['payment']['address_1']      = '';
                $this->session->data['guest']['payment']['address_2']      = '';
                $this->session->data['guest']['payment']['postcode']       = '';
                $this->session->data['guest']['payment']['city']           = '';
                $this->session->data['guest']['payment']['country_id']     = '';
                $this->session->data['guest']['payment']['country']        = '';
                $this->session->data['guest']['payment']['iso_code_2']     = '';
                $this->session->data['guest']['payment']['iso_code_3']     = '';
                $this->session->data['guest']['payment']['address_format'] = '';
                $this->session->data['guest']['payment']['zone']           = '';
                $this->session->data['guest']['payment']['zone_code']      = '';
                $this->session->data['guest']['payment']['zone_id']        = '';
                $this->session->data['guest']['shipping_address']          = false;
            }
            
            $this->session->data['account'] = 'guest';
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
        } else {
            unset($this->session->data['guest']);
            
            /**
             * if the user is logged in, add the address to the account and set the ID.
             */
            
            if ($this->cart->hasShipping()) {
                Theme::model('account/address');
                
                $addresses = $this->model_account_address->getAddresses();
                
                /**
                 * Compare all of the user addresses and see if there is a match
                 */
                $match = false;
                foreach ($addresses as $address) {
                    if (trim(strtolower($address['address_1'])) == trim(strtolower($result['PAYMENTREQUEST_0_SHIPTOSTREET'])) && trim(strtolower($address['postcode'])) == trim(strtolower($result['PAYMENTREQUEST_0_SHIPTOZIP']))) {
                        $match = true;
                        
                        $this->session->data['payment_address_id']  = $address['address_id'];
                        $this->session->data['payment_country_id']  = $address['country_id'];
                        $this->session->data['payment_zone_id']     = $address['zone_id'];
                        
                        $this->session->data['shipping_address_id'] = $address['address_id'];
                        $this->session->data['shipping_country_id'] = $address['country_id'];
                        $this->session->data['shipping_zone_id']    = $address['zone_id'];
                        $this->session->data['shipping_postcode']   = $address['postcode'];
                        
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
                    
                    $address_id = $this->model_account_address->addAddress($address_data);
                    
                    $this->session->data['payment_address_id']  = $address_id;
                    $this->session->data['payment_country_id']  = $address_data['country_id'];
                    $this->session->data['payment_zone_id']     = $address_data['zone_id'];
                    
                    $this->session->data['shipping_address_id'] = $address_id;
                    $this->session->data['shipping_country_id'] = $address_data['country_id'];
                    $this->session->data['shipping_zone_id']    = $address_data['zone_id'];
                    $this->session->data['shipping_postcode']   = $address_data['postcode'];
                }
            } else {
                $this->session->data['payment_address_id'] = '';
                $this->session->data['payment_country_id'] = '';
                $this->session->data['payment_zone_id']    = '';
            }
        }
        
        $this->response->redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
    }
    
    public function expressConfirm() {
        $data = Theme::language('payment/paypal_express');
        $data = Theme::language('checkout/cart', $data);
        
        Theme::model('tool/image');
        
        // Coupon
        if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
            $this->session->data['coupon']  = $this->request->post['coupon'];
            $this->session->data['success'] = Lang::get('lang_text_coupon');
            $this->response->redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
        }
        
        // Gift card
        if (isset($this->request->post['gift_card']) && $this->validateGiftcard()) {
            $this->session->data['gift_card'] = $this->request->post['gift_card'];
            $this->session->data['success'] = Lang::get('lang_text_gift_card');
            $this->response->redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
        }
        
        // Reward
        if (isset($this->request->post['reward']) && $this->validateReward()) {
            $this->session->data['reward']  = abs($this->request->post['reward']);
            $this->session->data['success'] = Lang::get('lang_text_reward');
            $this->response->redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
        }
        
        Theme::setTitle(Lang::get('lang_express_text_title'));
        
        $data['heading_title'] = Lang::get('lang_express_text_title');
        
        Breadcrumb::add('lang_text_title', 'payment/paypal_express/express', '', true, 'SSL');
        Breadcrumb::add('lang_express_text_title', 'payment/paypal_express/expressConfirm', '', true, 'SSL');
        
        $points_total = 0;
        
        foreach ($this->cart->getProducts() as $product) {
            if ($product['points']) {
                $points_total+= $product['points'];
            }
        }
        
        $data['button_shipping'] = Lang::get('lang_express_button_shipping');
        $data['button_confirm']  = Lang::get('lang_express_button_confirm');
        
        if (isset($this->request->post['next'])) {
            $data['next'] = $this->request->post['next'];
        } else {
            $data['next'] = '';
        }
        
        $data['action'] = Url::link('payment/paypal_express/expressConfirm', '', 'SSL');
        
        $products = $this->cart->getProducts();
        
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
                $image = $this->model_tool_image->resize($product['image'], Config::get('config_image_cart_width'), Config::get('config_image_cart_height'));
            } else {
                $image = '';
            }
            
            $option_data = array();
            
            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['option_value'];
                } else {
                    $filename = $this->encryption->decrypt($option['option_value']);
                    
                    $value    = $this->encode->substr($filename, 0, $this->encode->strrpos($filename, '.'));
                }
                
                $option_data[] = array(
                    'name'  => $option['name'], 
                    'value' => ($this->encode->strlen($value) > 20 ? $this->encode->substr($value, 0, 20) . '..' : $value)
                );
            }
            
            // Display prices
            if ((Config::get('config_customer_price') && $this->customer->isLogged()) || !Config::get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], Config::get('config_tax')));
            } else {
                $price = false;
            }
            
            // Display prices
            if ((Config::get('config_customer_price') && $this->customer->isLogged()) || !Config::get('config_customer_price')) {
                $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], Config::get('config_tax')) * $product['quantity']);
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
                    $recurring_price = $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax')));
                    $recurring_description = sprintf(Lang::get('lang_text_trial_description'), $recurring_price, $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                }
                
                $recurring_price = $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax')));
                
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
        
        if ($this->cart->hasShipping()) {
            
            $data['has_shipping'] = true;
            
            /**
             * Shipping services
             */
            if ($this->customer->isLogged()) {
                Theme::model('account/address');
                $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
            } elseif (isset($this->session->data['guest'])) {
                $shipping_address = $this->session->data['guest']['shipping'];
            }
            
            if (!empty($shipping_address)) {
                
                // Shipping Methods
                $quote_data = array();
                
                Theme::model('setting/module');
                
                $results = $this->model_setting_module->getModules('shipping');
                
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
                        
                        $this->session->data['shipping_methods'] = $quote_data;
                        $data['shipping_methods'] = $quote_data;
                        
                        if (!isset($this->session->data['shipping_method'])) {
                            
                            //default the shipping to the very first option.
                            $key1 = key($quote_data);
                            $key2 = key($quote_data[$key1]['quote']);
                            $this->session->data['shipping_method'] = $quote_data[$key1]['quote'][$key2];
                        }
                        
                        $data['code'] = $this->session->data['shipping_method']['code'];
                        $data['action_shipping'] = Url::link('payment/paypal_express/shipping', '', 'SSL');
                    } else {
                        unset($this->session->data['shipping_methods']);
                        unset($this->session->data['shipping_method']);
                        $data['error_no_shipping'] = Lang::get('lang_error_no_shipping');
                    }
                } else {
                    unset($this->session->data['shipping_methods']);
                    unset($this->session->data['shipping_method']);
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
        $taxes      = $this->cart->getTaxes();
        
        // Display prices
        if ((Config::get('config_customer_price') && $this->customer->isLogged()) || !Config::get('config_customer_price')) {
            $sort_order = array();
            
            $results = $this->model_setting_module->getModules('total');
            
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
                'text'  => $this->currency->format($total['value'])
            );
        }
        
        /**
         * Payment methods
         */
        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
            Theme::model('account/address');
            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
        } elseif (isset($this->session->data['guest'])) {
            $payment_address = $this->session->data['guest']['payment'];
        }
        
        $method_data = array();
        
        Theme::model('setting/module');
        
        $results = $this->model_setting_module->getModules('payment');
        
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
        
        $this->session->data['payment_methods'] = $method_data;
        $this->session->data['payment_method']  = $this->session->data['payment_methods']['paypal_express'];
        
        $data['action_confirm'] = Url::link('payment/paypal_express/expressComplete', '', 'SSL');
        
        if (isset($this->session->data['error_warning'])) {
            $data['error_warning'] = $this->session->data['error_warning'];
            unset($this->session->data['error_warning']);
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->session->data['attention'])) {
            $data['attention'] = $this->session->data['attention'];
            unset($this->session->data['attention']);
        } else {
            $data['attention'] = '';
        }
        
        Theme::loadjs('javascript/payment/paypalexpress_confirm', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('payment/paypalexpress_confirm', $data));
    }
    
    public function expressComplete() {
        $data     = Theme::language('payment/paypal_express');
        $redirect = '';
        
        if ($this->cart->hasShipping()) {
            
            // Validate if shipping address has been set.
            Theme::model('account/address');
            
            if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
                $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
            } elseif (isset($this->session->data['guest'])) {
                $shipping_address = $this->session->data['guest']['shipping'];
            }
            
            if (empty($shipping_address)) {
                $redirect = Url::link('checkout/checkout', '', 'SSL');
            }
            
            // Validate if shipping method has been set.
            if (!isset($this->session->data['shipping_method'])) {
                $redirect = Url::link('checkout/checkout', '', 'SSL');
            }
        } else {
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
        }
        
        // Validate if payment address has been set.
        Theme::model('account/address');
        
        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
        } elseif (isset($this->session->data['guest'])) {
            $payment_address = $this->session->data['guest']['payment'];
        }
        
        // Validate if payment method has been set.
        if (!isset($this->session->data['payment_method'])) {
            $redirect = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !Config::get('config_stock_checkout'))) {
            $redirect = Url::link('checkout/cart');
        }
        
        // Validate minimum quantity requirements.
        $products = $this->cart->getProducts();
        
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
            $taxes = $this->cart->getTaxes();
            
            Theme::model('setting/module');
            
            $sort_order = array();
            
            $results = $this->model_setting_module->getModules('total');
            
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
            
            if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
                $data['customer_id']       = $this->customer->getId();
                $data['customer_group_id'] = $this->customer->getGroupId();
                $data['firstname']         = $this->customer->getFirstName();
                $data['lastname']          = $this->customer->getLastName();
                $data['email']             = $this->customer->getEmail();
                $data['telephone']         = $this->customer->getTelephone();
                
                Theme::model('account/address');
                
                $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
            } elseif (isset($this->session->data['guest'])) {
                $data['customer_id']       = 0;
                $data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
                $data['firstname']         = $this->session->data['guest']['firstname'];
                $data['lastname']          = $this->session->data['guest']['lastname'];
                $data['email']             = $this->session->data['guest']['email'];
                $data['telephone']         = $this->session->data['guest']['telephone'];
                
                $payment_address = $this->session->data['guest']['payment'];
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
            if (isset($this->session->data['payment_method']['title'])) {
                $data['payment_method'] = $this->session->data['payment_method']['title'];
            }
            
            $data['payment_code'] = '';
            if (isset($this->session->data['payment_method']['code'])) {
                $data['payment_code'] = $this->session->data['payment_method']['code'];
            }
            
            if ($this->cart->hasShipping()) {
                if ($this->customer->isLogged()) {
                    Theme::model('account/address');
                    
                    $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
                } elseif (isset($this->session->data['guest'])) {
                    $shipping_address = $this->session->data['guest']['shipping'];
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
                if (isset($this->session->data['shipping_method']['title'])) {
                    $data['shipping_method'] = $this->session->data['shipping_method']['title'];
                }
                
                $data['shipping_code'] = '';
                if (isset($this->session->data['shipping_method']['code'])) {
                    $data['shipping_code'] = $this->session->data['shipping_method']['code'];
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
            
            foreach ($this->cart->getProducts() as $product) {
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
                    'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']), 
                    'reward'     => $product['reward']
                );
            }
            
            // Gift Giftcard
            $gift_card_data = array();
            
            if (!empty($this->session->data['gift_cards'])) {
                foreach ($this->session->data['gift_cards'] as $gift_card) {
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
            $data['comment']   = $this->session->data['comment'];
            $data['total']     = $total;

            $sub_total = $this->cart->getSubTotal();
            
            Theme::model('account/affiliate');

            /**
             * Start with setting affiliate_id to false;
             */
            
            $affiliate_id = false;

            /**
             * Let's handle all logged in customers first
             */
            if ($this->customer->isLogged() && ($this->customer->getReferralId() > 0)):
                $affiliate_id = $this->customer->getReferralId();
            endif;

            /**
             * Not logged in or no referral_id, we can try cookies.
             * make sure we check that the affiliate_id is not already set
             */
            
            // referrer cookie
            if (!$affiliate_id && isset($this->request->cookie['referrer'])):
                $affiliate_id = $this->request->cookie['referrer'];
            endif;

            // affiliate_id cookie
            if (!$affiliate_id && isset($this->request->cookie['affiliate_id'])):
                $affiliate_id = $this->request->cookie['affiliate_id'];
            endif;

            if ($affiliate_id && ($affiliate_id !== $this->customer->getId())):
                $data['affiliate_id'] = $affiliate_id;
                $percent              = $this->model_account_affiliate->getAffiliateCommission($affiliate_id);
                $commission           = $sub_total * ($percent / 100);
                $data['commission']   = number_format($commission, 2);
            else:
                $data['affiliate_id'] = 0;
                $data['commission']   = 0;
            endif;
            
            $data['language_id']    = Config::get('config_language_id');
            $data['currency_id']    = $this->currency->getId();
            $data['currency_code']  = $this->currency->getCode();
            $data['currency_value'] = $this->currency->getValue($this->currency->getCode());
            $data['ip']             = $this->request->server['REMOTE_ADDR'];
            
            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {
                $data['forwarded_ip'] = '';
            }
            
            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $data['user_agent'] = '';
            }
            
            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $data['accept_language'] = '';
            }
            
            Theme::model('checkout/order');
            
            $order_id = $this->model_checkout_order->addOrder($data);
            $this->session->data['order_id'] = $order_id;
            
            Theme::model('payment/paypal_express');
            
            $paypal_data = array(
                'TOKEN'                      => $this->session->data['paypal']['token'], 
                'PAYERID'                    => $this->session->data['paypal']['payerid'], 
                'METHOD'                     => 'DoExpressCheckoutPayment', 
                'PAYMENTREQUEST_0_NOTIFYURL' => Url::link('payment/paypal_express/ipn', '', 'SSL'), 
                'RETURNFMFDETAILS'           => 1
            );
            
            $paypal_data = array_merge($paypal_data, $this->model_payment_paypal_express->paymentRequestInfo());
            
            $result = $this->model_payment_paypal_express->call($paypal_data);
            
            if ($result['ACK'] == 'Success') {
                
                //handle order status
                switch ($result['PAYMENTINFO_0_PAYMENTSTATUS']) {
                    case 'Canceled_Reversal':
                        $order_status_id = Config::get('paypalexpress_canceled_reversal_status_id');
                        break;

                    case 'Completed':
                        $order_status_id = Config::get('paypalexpress_completed_status_id');
                        break;

                    case 'Denied':
                        $order_status_id = Config::get('paypalexpress_denied_status_id');
                        break;

                    case 'Expired':
                        $order_status_id = Config::get('paypalexpress_expired_status_id');
                        break;

                    case 'Failed':
                        $order_status_id = Config::get('paypalexpress_failed_status_id');
                        break;

                    case 'Pending':
                        $order_status_id = Config::get('paypalexpress_pending_status_id');
                        break;

                    case 'Processed':
                        $order_status_id = Config::get('paypalexpress_processed_status_id');
                        break;

                    case 'Refunded':
                        $order_status_id = Config::get('paypalexpress_refunded_status_id');
                        break;

                    case 'Reversed':
                        $order_status_id = Config::get('paypalexpress_reversed_status_id');
                        break;

                    case 'Voided':
                        $order_status_id = Config::get('paypalexpress_voided_status_id');
                        break;
                }
                
                $this->model_checkout_order->confirm($order_id, $order_status_id);
                
                //add order to paypal table
                $paypal_order_data = array(
                    'order_id'         => $order_id, 
                    'capture_status'   => (Config::get('paypalexpress_method') == 'Sale' ? 'Complete' : 'NotComplete'), 
                    'currency_code'    => $result['PAYMENTINFO_0_CURRENCYCODE'], 
                    'authorization_id' => $result['PAYMENTINFO_0_TRANSACTIONID'], 
                    'total'            => $result['PAYMENTINFO_0_AMT']
                );
                
                $paypal_order_id = $this->model_payment_paypal_express->addOrder($paypal_order_data);
                
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
                    'transaction_entity'    => (Config::get('paypalexpress_method') == 'Sale' ? 'payment' : 'auth'), 
                    'amount'                => $result['PAYMENTINFO_0_AMT'], 
                    'debug_data'            => json_encode($result)
                );
                
                $this->model_payment_paypal_express->addTransaction($paypal_transaction_data);
                
                $recurring_products = $this->cart->getRecurringProducts();
                
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
                            'TOKEN'              => $this->session->data['paypal']['token'], 
                            'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", mktime(gmdate("H"), gmdate("i") + 5, gmdate("s"), gmdate("m"), gmdate("d"), gmdate("y"))), 
                            'BILLINGPERIOD'      => $billing_period[$item['recurring']['frequency']], 
                            'BILLINGFREQUENCY'   => $item['recurring']['cycle'], 
                            'TOTALBILLINGCYCLES' => $item['recurring']['duration'], 
                            'AMT'                => $this->currency->format($this->tax->calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'], 
                            'CURRENCYCODE'       => $this->currency->getCode()
                        );
                        
                        //trial information
                        if ($item['recurring']['trial']) {
                            $data_trial = array(
                                'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring']['trial_frequency']], 
                                'TRIALBILLINGFREQUENCY'   => $item['recurring']['trial_cycle'], 
                                'TRIALTOTALBILLINGCYCLES' => $item['recurring']['trial_duration'], 
                                'TRIALAMT'                => $this->currency->format($this->tax->calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity']
                            );
                            
                            $trial_amt  = $this->currency->format($this->tax->calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
                            $trial_text = sprintf(Lang::get('lang_text_trial'), $trial_amt, $item['recurring']['trial_cycle'], $item['recurring']['trial_frequency'], $item['recurring']['trial_duration']);
                            
                            $data = array_merge($data, $data_trial);
                        } else {
                            $trial_text = '';
                        }
                        
                        $recurring_amt         = $this->currency->format($this->tax->calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
                        $recurring_description = $trial_text . sprintf(Lang::get('lang_text_recurring'), $recurring_amt, $item['recurring']['cycle'], $item['recurring']['frequency']);
                        
                        if ($item['recurring']['duration'] > 0) {
                            $recurring_description.= sprintf(Lang::get('lang_text_length'), $item['recurring']['duration']);
                        }
                        
                        //create new recurring and set to pending status as no payment has been made yet.
                        $recurring_id = $this->model_checkout_recurring->create($item, $order_id, $recurring_description);
                        
                        $data['PROFILEREFERENCE'] = $recurring_id;
                        $data['DESC']             = $recurring_description;
                        
                        $result = $this->model_payment_paypal_express->call($data);
                        
                        if (isset($result['PROFILEID'])) {
                            $this->model_checkout_recurring->addReference($recurring_id, $result['PROFILEID']);
                        } else {
                            
                            // there was an error creating the recurring, need to log and also alert admin / user
                            
                            
                        }
                    }
                }
                
                $this->response->redirect(Url::link('checkout/success'));
                
                if (isset($result['REDIRECTREQUIRED']) && $result['REDIRECTREQUIRED'] === true) {
                    
                    //- handle german redirect here
                    $this->response->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . $this->session->data['paypal']['token']);
                }
            } else {
                if ($result['L_ERRORCODE0'] == '10486') {
                    if (isset($this->session->data['paypal_redirect_count'])) {
                        
                        if ($this->session->data['paypal_redirect_count'] == 2) {
                            $this->session->data['paypal_redirect_count'] = 0;
                            $this->session->data['error'] = Lang::get('lang_error_too_many_failures');
                            $this->response->redirect(Url::link('checkout/checkout', '', 'SSL'));
                        } else {
                            $this->session->data['paypal_redirect_count']++;
                        }
                    } else {
                        $this->session->data['paypal_redirect_count'] = 1;
                    }
                    
                    if (Config::get('paypalexpress_test') == 1) {
                        $this->response->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
                    } else {
                        $this->response->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
                    }
                }
                
                $this->session->data['error'] = $result['L_LONGMESSAGE0'];
                $this->response->redirect(Url::link('payment/paypal_express/expressConfirm', '', 'SSL'));
            }
        } else {
            $this->response->redirect($redirect);
        }
    }
    
    public function checkout() {
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !Config::get('config_stock_checkout'))) {
            $this->response->redirect(Url::link('checkout/cart'));
        }
        
        Theme::model('payment/paypal_express');
        Theme::model('tool/image');
        Theme::model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $max_amount = $this->currency->convert($order_info['total'], Config::get('config_currency'), 'USD');
        $max_amount = min($max_amount * 1.25, 10000);
        $max_amount = $this->currency->format($max_amount, $this->currency->getCode(), '', false);
        
        $data = array(
            'METHOD'             => 'SetExpressCheckout', 
            'MAXAMT'             => $max_amount, 
            'RETURNURL'          => Url::link('payment/paypal_express/checkoutReturn', '', 'SSL'), 
            'CANCELURL'          => Url::link('checkout/checkout', '', 'SSL'), 
            'REQCONFIRMSHIPPING' => 0, 
            'NOSHIPPING'         => 1, 
            'LOCALECODE'         => 'EN', 
            'LANDINGPAGE'        => 'Login', 
            'HDRIMG'             => $this->model_tool_image->resize(Config::get('paypalexpress_logo'), 790, 90), 
            'PAYFLOWCOLOR'       => Config::get('paypalexpress_page_colour'), 
            'CHANNELTYPE'        => 'Merchant', 
            'ALLOWNOTE'          => Config::get('paypalexpress_allow_note')
        );
        
        if (isset($this->session->data['paypalexpress_login']['seamless']['access_token']) && (isset($this->session->data['paypalexpress_login']['seamless']['customer_id']) && $this->session->data['paypalexpress_login']['seamless']['customer_id'] == $this->customer->getId()) && Config::get('paypalexpress_login_seamless')) {
            $data['IDENTITYACCESSTOKEN'] = $this->session->data['paypalexpress_login']['seamless']['access_token'];
        }
        
        $data = array_merge($data, $this->model_payment_paypal_express->paymentRequestInfo());
        
        $result = $this->model_payment_paypal_express->call($data);
        
        /**
         * If a failed PayPal setup happens, handle it.
         */
        if (!isset($result['TOKEN'])) {
            $this->session->data['error'] = $result['L_LONGMESSAGE0'];
            
            /**
             * Unable to add error message to user as the session errors/success are not
             * used on the cart or checkout pages - need to be added?
             * If PayPal debug log is off then still log error to normal error log.
             */
            if (Config::get('paypalexpress_debug') == 1) {
                $this->log->write(serialize($result));
            }
            
            $this->response->redirect(Url::link('checkout/checkout', '', 'SSL'));
        }
        
        $this->session->data['paypal']['token'] = $result['TOKEN'];
        
        if (Config::get('paypalexpress_test') == 1) {
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
        
        $data = array('METHOD' => 'GetExpressCheckoutDetails', 'TOKEN' => $this->session->data['paypal']['token']);
        
        $result = $this->model_payment_paypal_express->call($data);
        
        $this->session->data['paypal']['payerid'] = $result['PAYERID'];
        $this->session->data['paypal']['result'] = $result;
        
        $order_id = $this->session->data['order_id'];
        
        $paypal_data = array(
            'TOKEN'                      => $this->session->data['paypal']['token'], 
            'PAYERID'                    => $this->session->data['paypal']['payerid'], 
            'METHOD'                     => 'DoExpressCheckoutPayment', 
            'PAYMENTREQUEST_0_NOTIFYURL' => Url::link('payment/paypal_express/ipn', '', 'SSL'), 
            'RETURNFMFDETAILS'           => 1
        );
        
        $paypal_data = array_merge($paypal_data, $this->model_payment_paypal_express->paymentRequestInfo());
        
        $result = $this->model_payment_paypal_express->call($paypal_data);
        
        if ($result['ACK'] == 'Success') {
            
            //handle order status
            switch ($result['PAYMENTINFO_0_PAYMENTSTATUS']) {
                case 'Canceled_Reversal':
                    $order_status_id = Config::get('paypalexpress_canceled_reversal_status_id');
                    break;

                case 'Completed':
                    $order_status_id = Config::get('paypalexpress_completed_status_id');
                    break;

                case 'Denied':
                    $order_status_id = Config::get('paypalexpress_denied_status_id');
                    break;

                case 'Expired':
                    $order_status_id = Config::get('paypalexpress_expired_status_id');
                    break;

                case 'Failed':
                    $order_status_id = Config::get('paypalexpress_failed_status_id');
                    break;

                case 'Pending':
                    $order_status_id = Config::get('paypalexpress_pending_status_id');
                    break;

                case 'Processed':
                    $order_status_id = Config::get('paypalexpress_processed_status_id');
                    break;

                case 'Refunded':
                    $order_status_id = Config::get('paypalexpress_refunded_status_id');
                    break;

                case 'Reversed':
                    $order_status_id = Config::get('paypalexpress_reversed_status_id');
                    break;

                case 'Voided':
                    $order_status_id = Config::get('paypalexpress_voided_status_id');
                    break;
            }
            
            $this->model_checkout_order->confirm($order_id, $order_status_id);
            
            //add order to paypal table
            $paypal_order_data = array(
                'order_id'         => $order_id, 
                'capture_status'   => (Config::get('paypalexpress_method') == 'Sale' ? 'Complete' : 'NotComplete'), 
                'currency_code'    => $result['PAYMENTINFO_0_CURRENCYCODE'], 
                'authorization_id' => $result['PAYMENTINFO_0_TRANSACTIONID'], 
                'total'            => $result['PAYMENTINFO_0_AMT']
            );
            
            $paypal_order_id = $this->model_payment_paypal_express->addOrder($paypal_order_data);
            
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
                'transaction_entity'    => (Config::get('paypalexpress_method') == 'Sale' ? 'payment' : 'auth'), 
                'amount'                => $result['PAYMENTINFO_0_AMT'], 
                'debug_data'            => json_encode($result)
            );

            $this->model_payment_paypal_express->addTransaction($paypal_transaction_data);
            
            $recurring_products = $this->cart->getRecurringProducts();
            
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
                        'TOKEN'              => $this->session->data['paypal']['token'], 
                        'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", mktime(gmdate('H'), gmdate('i') + 5, gmdate('s'), gmdate('m'), gmdate('d'), gmdate('y'))), 
                        'BILLINGPERIOD'      => $billing_period[$item['recurring']['frequency']], 
                        'BILLINGFREQUENCY'   => $item['recurring']['cycle'], 
                        'TOTALBILLINGCYCLES' => $item['recurring']['duration'], 
                        'AMT'                => $this->currency->format($this->tax->calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'], 
                        'CURRENCYCODE'       => $this->currency->getCode()
                    );
                    
                    //trial information
                    if ($item['recurring']['trial'] == 1) {
                        $data_trial = array(
                            'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring']['trial_frequency']], 
                            'TRIALBILLINGFREQUENCY'   => $item['recurring']['trial_cycle'], 
                            'TRIALTOTALBILLINGCYCLES' => $item['recurring']['trial_duration'], 
                            'TRIALAMT'                => $this->currency->format($this->tax->calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity']
                        );
                        
                        $trial_amt = $this->currency->format($this->tax->calculate($item['recurring']['trial_price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
                        $trial_text = sprintf(Lang::get('lang_text_trial'), $trial_amt, $item['recurring']['trial_cycle'], $item['recurring']['trial_frequency'], $item['recurring']['trial_duration']);
                        
                        $data = array_merge($data, $data_trial);
                    } else {
                        $trial_text = '';
                    }
                    
                    $recurring_amt         = $this->currency->format($this->tax->calculate($item['recurring']['price'], $item['tax_class_id'], Config::get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
                    $recurring_description = $trial_text . sprintf(Lang::get('lang_text_recurring'), $recurring_amt, $item['recurring']['cycle'], $item['recurring']['frequency']);
                    
                    if ($item['recurring']['duration'] > 0) {
                        $recurring_description.= sprintf(Lang::get('lang_text_length'), $item['recurring']['duration']);
                    }
                    
                    //create new recurring and set to pending status as no payment has been made yet.
                    $recurring_id = $this->model_checkout_recurring->create($item, $order_id, $recurring_description);
                    
                    $data['PROFILEREFERENCE'] = $recurring_id;
                    $data['DESC']             = $recurring_description;
                    
                    $result = $this->model_payment_paypal_express->call($data);
                    
                    if (isset($result['PROFILEID'])) {
                        $this->model_checkout_recurring->addReference($recurring_id, $result['PROFILEID']);
                    } else {
                        
                        // there was an error creating the recurring, need to log and also alert admin / user
                        
                        
                    }
                }
            }
            
            if (isset($result['REDIRECTREQUIRED']) && $result['REDIRECTREQUIRED'] === true) {
                
                //- handle german redirect here
                $this->response->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . $this->session->data['paypal']['token']);
            } else {
                $this->response->redirect(Url::link('checkout/success'));
            }
        } else {
            
            if ($result['L_ERRORCODE0'] == '10486') {
                if (isset($this->session->data['paypal_redirect_count'])) {
                    
                    if ($this->session->data['paypal_redirect_count'] == 2) {
                        $this->session->data['paypal_redirect_count'] = 0;
                        $this->session->data['error'] = Lang::get('lang_error_too_many_failures');
                        
                        $this->response->redirect(Url::link('checkout/checkout', '', 'SSL'));
                    } else {
                        $this->session->data['paypal_redirect_count']++;
                    }
                } else {
                    $this->session->data['paypal_redirect_count'] = 1;
                }
                
                if (Config::get('paypalexpress_test') == 1) {
                    $this->response->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
                } else {
                    $this->response->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
                }
            }
            
            Breadcrumb::add('lang_text_cart', 'checkout/cart', '', true, 'SSL');
            
            $data['heading_title'] = Lang::get('lang_error_heading_title');
            
            $data['text_error'] = '<div class="alert alert-danger">' . $result['L_ERRORCODE0'] . ' : ' . $result['L_LONGMESSAGE0'] . '</div>';
            
            $data['continue'] = Url::link('checkout/cart', '', 'SSL');
            
            unset($this->session->data['success']);
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('error/not_found', $data));
        }
    }
    
    public function ipn() {
        Theme::model('payment/paypal_express');
        Theme::model('payment/express_ipn');
        Theme::model('account/recurring');
        
        $request = 'cmd=_notify-validate';
        
        if (Config::get('paypalexpress_test') == 1) {
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
            $this->model_payment_paypal_express->log(array(
                    'error'    => curl_error($curl), 
                    'error_no' => curl_errno($curl)
                ), 'Curl failed'
            );
        }
        
        $this->model_payment_paypal_express->log(array(
                'request'  => $request, 
                'response' => $response
            ), 'IPN data'
        );
        
        if ((string)$response == "VERIFIED") {
            
            if (Config::get('paypalexpress_debug') == 1) {
                if (isset($this->request->post['transaction_entity'])) $this->log->write($this->request->post['transaction_entity']);
            }
            
            if (isset($this->request->post['txn_id'])) {
                $transaction = $this->model_payment_paypal_express->getTransactionRow($this->request->post['txn_id']);
            } else {
                $transaction = false;
            }
            
            if ($transaction) {
                
                //transaction exists, check for cleared payment or updates etc
                if (Config::get('paypalexpress_debug') == 1) $this->log->write('Transaction exists');
                
                //if the transaction is pending but the new status is completed
                if ($transaction['payment_status'] != $this->request->post['payment_status']) {
                    $this->model_payment_express_ipn->updateStatus($this->request->post['payment_status'], $transaction['transaction_id']);
                } elseif ($transaction['payment_status'] == 'Pending' && ($transaction['pending_reason'] != $this->request->post['pending_reason'])) {
                    $this->model_payment_express_ipn->updatePending($this->request->post['pending_reason'], $transaction['transaction_id']);
                }
            } else {
                if (Config::get('paypalexpress_debug') == 1) $this->log->write('Transaction does not exist');
                
                $parent_transaction = false;
                
                if (isset($this->request->post['parent_txn_id'])) {
                    $parent_transaction = $this->model_payment_paypal_express->getTransactionRow($this->request->post['parent_txn_id']);
                } else {
                    $parent_transaction = $this->model_payment_paypal_express->getTransactionRowByReference($this->request->post['recurring_payment_id']);
                }
                
                if ($parent_transaction) {
                    if (Config::get('paypalexpress_debug') == 1) $this->log->write('Parent transaction exists');
                    
                    //parent transaction exists
                    //add new related transaction
                    $transaction = array(
                        'paypal_order_id'       => $parent_transaction['paypal_order_id'], 
                        'transaction_id'        => $this->request->post['txn_id'], 
                        'parent_transaction_id' => $parent_transaction['transaction_id'], 
                        'note'                  => '', 
                        'msgsubid'              => '', 
                        'receipt_id'            => (isset($this->request->post['receipt_id']) ? $this->request->post['receipt_id'] : ''), 
                        'payment_type'          => (isset($this->request->post['payment_type']) ? $this->request->post['payment_type'] : ''), 
                        'payment_status'        => (isset($this->request->post['payment_status']) ? $this->request->post['payment_status'] : ''), 
                        'pending_reason'        => (isset($this->request->post['pending_reason']) ? $this->request->post['pending_reason'] : ''), 
                        'amount'                => $this->request->post['mc_gross'], 
                        'debug_data'            => json_encode($this->request->post), 
                        'transaction_entity'    => (isset($this->request->post['transaction_entity']) ? $this->request->post['transaction_entity'] : '')
                    );
                    
                    $this->model_payment_paypal_express->addTransaction($transaction);
                    
                    /**
                     * If there has been a refund, log this against the parent transaction.
                     */
                    if (isset($this->request->post['payment_status']) && $this->request->post['payment_status'] == 'Refunded') {
                        $this->model_payment_express_ipn->processRefund($this->request->post['mc_gross'], $parent_transaction['amount'], $parent_transaction['transaction_id']);
                    }
                    
                    /**
                     * If the capture payment is now complete
                     */
                    if (isset($this->request->post['auth_status']) && $this->request->post['auth_status'] == 'Completed' && $parent_transaction['payment_status'] == 'Pending') {
                        $captured  = $this->currency->format($this->model_payment_paypal_express->totalCaptured($parent_transaction['paypal_order_id']), false, false, false);
                        $refunded  = $this->currency->format($this->model_payment_paypal_express->totalRefundedOrder($parent_transaction['paypal_order_id']), false, false, false);
                        $remaining = $this->currency->format($parent_transaction['amount'] - $captured + $refunded, false, false, false);
                        
                        if (Config::get('paypalexpress_debug') == 1) {
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
                            
                            $this->model_payment_paypal_express->addTransaction($transaction);
                        }
                        
                        $this->model_payment_paypal_express->updateOrder('Complete', $parent_transaction['order_id']);
                    }
                } else {
                    
                    //parent transaction doesn't exists, need to investigate?
                    if (Config::get('paypalexpress_debug') == 1) $this->log->write('Parent transaction not found');
                }
            }
            
            /*
             * Subscription payments
             *
             * recurring ID should always exist if its a recurring payment transaction.
             *
             * also the reference will match a recurring payment ID
            */
            
            if (isset($this->request->post['txn_type'])) {
                
                //payment
                if ($this->request->post['txn_type'] == 'recurring_payment') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->processPayment($recur['order_recurring_id'], $this->request->post['amount'], $recur['status']);
                    }
                }
                
                //suspend
                if ($this->request->post['txn_type'] == 'recurring_payment_suspended') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->processSuspend($recur['order_recurring_id']);
                    }
                }
                
                //suspend due to max failed
                if ($this->request->post['txn_type'] == 'recurring_payment_suspended_due_to_max_failed_payment') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->suspendMaxFailed($recur['order_recurring_id']);
                    }
                }
                
                //payment failed
                if ($this->request->post['txn_type'] == 'recurring_payment_failed') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->paymentFailed($recur['order_recurring_id']);
                    }
                }
                
                //outstanding payment failed
                if ($this->request->post['txn_type'] == 'recurring_payment_outstanding_payment_failed') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->outstandingPaymentFailed($recur['order_recurring_id']);
                    }
                }
                
                //outstanding payment
                if ($this->request->post['txn_type'] == 'recurring_payment_outstanding_payment') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->outstandingPayment($recur['order_recurring_id'], $this->request->post['amount'], $recur['status']);
                    }
                }
                
                //date_added
                if ($this->request->post['txn_type'] == 'recurring_payment_recurring_date_added') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->dateAdded($recur['order_recurring_id'], $recur['status']);
                    }
                }
                
                //canceled
                if ($this->request->post['txn_type'] == 'recurring_payment_recurring_cancel') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false && $recur['status'] != 3) {
                        $this->model_payment_express_ipn->processCanceled($recur['order_recurring_id']);
                    }
                }
                
                //skipped
                if ($this->request->post['txn_type'] == 'recurring_payment_skipped') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->processSkipped($recur['order_recurring_id']);
                    }
                }
                
                //expired
                if ($this->request->post['txn_type'] == 'recurring_payment_expired') {
                    $recur = $this->model_account_recurring->getRecurringByRef($this->request->post['recurring_payment_id']);
                    
                    if ($recur !== false) {
                        $this->model_payment_express_ipn->processExpired($recur['order_recurring_id']);
                    }
                }
            }
        } elseif ((string)$response == "INVALID") {
            $this->model_payment_paypal_express->log(array('IPN was invalid'), 'IPN fail');
        } else {
            if (Config::get('paypalexpress_debug') == 1) {
                $this->log->write('string unknown ');
            }
        }
        
        header("HTTP/1.1 200 Ok");
    }
    
    public function shipping() {
        $this->shippingValidate($this->request->post['shipping_method']);
        
        $this->response->redirect(Url::link('payment/paypal_express/expressConfirm'));
    }
    
    protected function shippingValidate($code) {
        Theme::language('checkout/cart');
        Theme::language('payment/paypal_express');
        
        if (empty($code)) {
            $this->session->data['error_warning'] = Lang::get('lang_error_shipping');
            return false;
        } else {
            $shipping = explode('.', $code);
            
            if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                $this->session->data['error_warning'] = Lang::get('lang_error_shipping');
                return false;
            } else {
                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
                $this->session->data['success'] = Lang::get('lang_text_shipping_updated');
                return true;
            }
        }
    }
    
    public function recurringCancel() {
        
        //cancel an active recurring
        
        Theme::model('account/recurring');
        Theme::model('payment/paypal_express');
        Theme::language('account/recurring');
        
        $recur = $this->model_account_recurring->getRecurring($this->request->get['recurring_id']);
        
        if ($recur && !empty($recur['reference'])) {
            
            $result = $this->model_payment_paypal_express->recurringCancel($recur['reference']);
            
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
                
                $this->session->data['success'] = Lang::get('lang_text_cancelled');
            } else {
                $this->session->data['error'] = sprintf(Lang::get('lang_error_not_cancelled'), $result['L_LONGMESSAGE0']);
            }
        } else {
            $this->session->data['error'] = Lang::get('lang_error_not_found');
        }
        
        $this->response->redirect(Url::link('account/recurring/info', 'recurring_id=' . $this->request->get['recurring_id'], 'SSL'));
    }
    
    protected function validateCoupon() {
        Theme::model('checkout/coupon');
        
        $coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);
        
        $error = '';
        
        if (!$coupon_info) {
            $error = Lang::get('lang_error_coupon');
        }
        
        if (!$error) {
            return true;
        } else {
            $this->session->data['error_warning'] = $error;
            return false;
        }
    }
    
    protected function validateGiftcard() {
        Theme::model('checkout/gift_card');
        
        $gift_card_info = $this->model_checkout_gift_card->getGiftcard($this->request->post['gift_card']);
        
        $error = '';
        
        if (!$gift_card_info) {
            $error = Lang::get('lang_error_gift_card');
        }
        
        if (!$error) {
            return true;
        } else {
            $this->session->data['error_warning'] = Lang::get('lang_error_gift_card');;
            return false;
        }
    }
    
    protected function validateReward() {
        $points = $this->customer->getRewardPoints();
        
        $points_total = 0;
        
        foreach ($this->cart->getProducts() as $product) {
            if ($product['points']) {
                $points_total+= $product['points'];
            }
        }
        
        $error = '';
        
        if (empty($this->request->post['reward'])) {
            $error = Lang::get('lang_error_reward');
        }
        
        if ($this->request->post['reward'] > $points) {
            $error = sprintf(Lang::get('lang_error_points'), $this->request->post['reward']);
        }
        
        if ($this->request->post['reward'] > $points_total) {
            $error = sprintf(Lang::get('lang_error_maximum'), $points_total);
        }
        
        if (!$error) {
            return true;
        } else {
            $this->session->data['error_warning'] = $error;
            return false;
        }
    }
    
    public function recurringButtons() {
        $data = Theme::language('payment/paypal_express');
        
        $recur = $this->model_account_recurring->getRecurring($this->request->get['recurring_id']);
        
        $data['buttons'] = array();
        
        if ($recur['status'] == 2 || $recur['status'] == 3) {
            $data['buttons'][] = array(
                'text' => Lang::get('lang_button_cancel_recurring'), 
                'link' => Url::link('payment/paypal_express/recurringCancel', 'recurring_id=' . $this->request->get['recurring_id'], 'SSL')
            );
        }
        
        $data['buttons'][] = array(
            'text' => Lang::get('lang_button_continue'), 
            'link' => Url::link('account/recurring', '', 'SSL')
        );
        
        return Theme::view('common/buttons', $data);
    }
}
