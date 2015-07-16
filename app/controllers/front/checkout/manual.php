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
use Dais\Services\Providers\User;

class Manual extends Controller {
    
    public function index() {
        Theme::language('checkout/manual');
        
        $json = array();
        
        $this->user = new User;
        $this->user->login(Config::get('config_admin_email_user'), '', true);
        
        if ($this->user->isLogged() && $this->user->hasPermission('modify', 'sale/order')) {
            
            // Reset everything
            Cart::clear();
            Customer::logout();
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
            
            // Settings
            Theme::model('setting/setting');
            
            $settings = SettingSetting::getSetting('config', $this->request->post['store_id']);
            
            foreach ($settings as $key => $value) {
                Config::set($key, $value);
            }
            
            // Customer
            if ($this->request->post['customer_id']) {
                Theme::model('account/customer');
                
                $customer_info = AccountCustomer::getCustomer($this->request->post['customer_id']);
                
                if ($customer_info) {
                    Customer::login($customer_info['email'], '', true);
                    Cart::clear();
                } else {
                    $json['error']['customer'] = Lang::get('lang_error_customer');
                }
            } else {
                
                // Customer Group
                Config::set('config_customer_group_id', $this->request->post['customer_group_id']);
            }
            
            // Product
            Theme::model('catalog/product');
            
            if (isset($this->request->post['order_product'])) {
                foreach ($this->request->post['order_product'] as $order_product) {
                    $product_info = CatalogProduct::getProduct($order_product['product_id']);
                    
                    if ($product_info) {
                        $option_data = array();
                        
                        if (isset($order_product['order_option'])) {
                            foreach ($order_product['order_option'] as $option) {
                                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') {
                                    $option_data[$option['product_option_id']] = $option['product_option_value_id'];
                                } elseif ($option['type'] == 'checkbox') {
                                    $option_data[$option['product_option_id']][] = $option['product_option_value_id'];
                                } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                                    $option_data[$option['product_option_id']] = $option['value'];
                                }
                            }
                        }
                        
                        Cart::add($order_product['product_id'], $order_product['quantity'], $option_data);
                    }
                }
            }
            
            if (isset($this->request->post['product_id'])) {
                $product_info = CatalogProduct::getProduct($this->request->post['product_id']);
                
                if ($product_info) {
                    if (isset($this->request->post['quantity'])) {
                        $quantity = $this->request->post['quantity'];
                    } else {
                        $quantity = 1;
                    }
                    
                    if (isset($this->request->post['option'])) {
                        $option = array_filter($this->request->post['option']);
                    } else {
                        $option = array();
                    }
                    
                    $product_options = CatalogProduct::getProductOptions($this->request->post['product_id']);
                    
                    foreach ($product_options as $product_option) {
                        if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                            $json['error']['product']['option'][$product_option['product_option_id']] = sprintf(Lang::get('lang_error_required'), $product_option['name']);
                        }
                    }
                    
                    if (!isset($json['error']['product']['option'])) {
                        Cart::add($this->request->post['product_id'], $quantity, $option);
                    }
                }
            }
            
            // Stock
            if (!Cart::hasStock() && (!Config::get('config_stock_checkout') || Config::get('config_stock_warning'))) {
                $json['error']['product']['stock'] = Lang::get('lang_error_stock');
            }
            
            // Tax
            if (Cart::hasShipping()) {
                Tax::setShippingAddress($this->request->post['shipping_country_id'], $this->request->post['shipping_zone_id']);
            } else {
                Tax::setShippingAddress(Config::get('config_country_id'), Config::get('config_zone_id'));
            }
            
            Tax::setPaymentAddress($this->request->post['payment_country_id'], $this->request->post['payment_zone_id']);
            Tax::setStoreAddress(Config::get('config_country_id'), Config::get('config_zone_id'));
            
            // Products
            $json['order_product'] = array();
            
            $products = Cart::getProducts();
            
            foreach ($products as $product) {
                $product_total = 0;
                
                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total+= $product_2['quantity'];
                    }
                }
                
                if ($product['minimum'] > $product_total) {
                    $json['error']['product']['minimum'][] = sprintf(Lang::get('lang_error_minimum'), $product['name'], $product['minimum']);
                }
                
                $option_data = array();
                
                foreach ($product['option'] as $option) {
                    $option_data[] = array(
                        'product_option_id'       => $option['product_option_id'], 
                        'product_option_value_id' => $option['product_option_value_id'], 
                        'name'                    => $option['name'], 
                        'value'                   => $option['option_value'], 
                        'type'                    => $option['type']
                    );
                }
                
                $download_data = array();
                
                foreach ($product['download'] as $download) {
                    $download_data[] = array(
                        'name'      => $download['name'], 
                        'filename'  => $download['filename'], 
                        'mask'      => $download['mask'], 
                        'remaining' => $download['remaining']
                    );
                }
                
                $json['order_product'][] = array(
                    'product_id' => $product['product_id'], 
                    'name'       => $product['name'], 
                    'model'      => $product['model'], 
                    'option'     => $option_data, 
                    'download'   => $download_data, 
                    'quantity'   => $product['quantity'], 
                    'stock'      => $product['stock'], 
                    'price'      => number_format($product['price'], 2), 
                    'total'      => number_format($product['total'], 2), 
                    'tax'        => number_format(Tax::getTax($product['price'], $product['tax_class_id']), 2), 
                    'reward'     => $product['reward']
                );
            }
            
            // Giftcard
            $this->session->data['gift_cards'] = array();
            
            if (isset($this->request->post['order_gift_card'])) {
                foreach ($this->request->post['order_gift_card'] as $gift_card) {
                    $this->session->data['gift_cards'][] = array(
                        'gift_card_id'       => $gift_card['gift_card_id'], 
                        'description'       => $gift_card['description'], 
                        'code'              => substr(md5(mt_rand()), 0, 10), 
                        'from_name'         => $gift_card['from_name'], 
                        'from_email'        => $gift_card['from_email'], 
                        'to_name'           => $gift_card['to_name'], 
                        'to_email'          => $gift_card['to_email'], 
                        'gift_card_theme_id' => $gift_card['gift_card_theme_id'], 
                        'message'           => $gift_card['message'], 
                        'amount'            => number_format($gift_card['amount'], 2)
                    );
                }
            }
            
            // Add a new gift_card if set
            if (isset($this->request->post['from_name']) && isset($this->request->post['from_email']) && isset($this->request->post['to_name']) && isset($this->request->post['to_email']) && isset($this->request->post['amount'])) {
                if ((Encode::strlen($this->request->post['from_name']) < 1) || (Encode::strlen($this->request->post['from_name']) > 64)) {
                    $json['error']['gift_cards']['from_name'] = Lang::get('lang_error_from_name');
                }
                
                if ((Encode::strlen($this->request->post['from_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['from_email'])) {
                    $json['error']['gift_cards']['from_email'] = Lang::get('lang_error_email');
                }
                
                if ((Encode::strlen($this->request->post['to_name']) < 1) || (Encode::strlen($this->request->post['to_name']) > 64)) {
                    $json['error']['gift_cards']['to_name'] = Lang::get('lang_error_to_name');
                }
                
                if ((Encode::strlen($this->request->post['to_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['to_email'])) {
                    $json['error']['gift_cards']['to_email'] = Lang::get('lang_error_email');
                }
                
                if (($this->request->post['amount'] < 1) || ($this->request->post['amount'] > 1000)) {
                    $json['error']['gift_cards']['amount'] = sprintf(Lang::get('lang_error_amount'), Currency::format(1, false, 1), Currency::format(1000, false, 1) . ' ' . Config::get('config_currency'));
                }
                
                if (!isset($json['error']['gift_cards'])) {
                    $gift_card_data = array(
                        'order_id'          => 0, 
                        'code'              => substr(md5(mt_rand()), 0, 10), 
                        'from_name'         => $this->request->post['from_name'], 
                        'from_email'        => $this->request->post['from_email'], 
                        'to_name'           => $this->request->post['to_name'], 
                        'to_email'          => $this->request->post['to_email'], 
                        'gift_card_theme_id' => $this->request->post['gift_card_theme_id'], 
                        'message'           => $this->request->post['message'], 
                        'amount'            => $this->request->post['amount'], 
                        'status'            => true
                    );
                    
                    Theme::model('checkout/gift_card');
                    
                    $gift_card_id = CheckoutGiftCard::addGiftcard(0, $gift_card_data);
                    
                    $this->session->data['gift_cards'][] = array(
                        'gift_card_id'       => $gift_card_id, 
                        'description'       => sprintf(Lang::get('lang_text_for'), Currency::format($this->request->post['amount'], Config::get('config_currency')), $this->request->post['to_name']), 
                        'code'              => substr(md5(mt_rand()), 0, 10), 
                        'from_name'         => $this->request->post['from_name'], 
                        'from_email'        => $this->request->post['from_email'], 
                        'to_name'           => $this->request->post['to_name'], 
                        'to_email'          => $this->request->post['to_email'], 
                        'gift_card_theme_id' => $this->request->post['gift_card_theme_id'], 
                        'message'           => $this->request->post['message'], 
                        'amount'            => $this->request->post['amount']
                    );
                }
            }
            
            $json['order_gift_card'] = array();
            
            foreach ($this->session->data['gift_cards'] as $gift_card) {
                $json['order_gift_card'][] = array(
                    'gift_card_id'       => $gift_card['gift_card_id'], 
                    'description'       => $gift_card['description'], 
                    'code'              => $gift_card['code'], 
                    'from_name'         => $gift_card['from_name'], 
                    'from_email'        => $gift_card['from_email'], 
                    'to_name'           => $gift_card['to_name'], 
                    'to_email'          => $gift_card['to_email'], 
                    'gift_card_theme_id' => $gift_card['gift_card_theme_id'], 
                    'message'           => $gift_card['message'], 
                    'amount'            => number_format($gift_card['amount'], 2)
                );
            }
            
            Theme::model('setting/module');
            
            Theme::model('locale/country');
            
            Theme::model('locale/zone');
            
            // Shipping
            $json['shipping_method'] = array();
            
            if (Cart::hasShipping()) {
                Theme::model('locale/country');
                
                $country_info = LocaleCountry::getCountry($this->request->post['shipping_country_id']);
                
                if ($country_info && $country_info['postcode_required'] && (Encode::strlen($this->request->post['shipping_postcode']) < 2) || (Encode::strlen($this->request->post['shipping_postcode']) > 10)) {
                    $json['error']['shipping']['postcode'] = Lang::get('lang_error_postcode');
                }
                
                if ($this->request->post['shipping_country_id'] == '') {
                    $json['error']['shipping']['country'] = Lang::get('lang_error_country');
                }
                
                if (!isset($this->request->post['shipping_zone_id']) || $this->request->post['shipping_zone_id'] == '') {
                    $json['error']['shipping']['zone'] = Lang::get('lang_error_zone');
                }
                
                Theme::model('locale/country');
                
                $country_info = LocaleCountry::getCountry($this->request->post['shipping_country_id']);
                
                if ($country_info && $country_info['postcode_required'] && (Encode::strlen($this->request->post['shipping_postcode']) < 2) || (Encode::strlen($this->request->post['shipping_postcode']) > 10)) {
                    $json['error']['shipping']['postcode'] = Lang::get('lang_error_postcode');
                }
                
                if (!isset($json['error']['shipping'])) {
                    if ($country_info) {
                        $country        = $country_info['name'];
                        $iso_code_2     = $country_info['iso_code_2'];
                        $iso_code_3     = $country_info['iso_code_3'];
                        $address_format = $country_info['address_format'];
                    } else {
                        $country        = '';
                        $iso_code_2     = '';
                        $iso_code_3     = '';
                        $address_format = '';
                    }
                    
                    $zone_info = LocaleZone::getZone($this->request->post['shipping_zone_id']);
                    
                    if ($zone_info) {
                        $zone      = $zone_info['name'];
                        $zone_code = $zone_info['code'];
                    } else {
                        $zone      = '';
                        $zone_code = '';
                    }
                    
                    $address_data = array(
                        'firstname'      => $this->request->post['shipping_firstname'], 
                        'lastname'       => $this->request->post['shipping_lastname'], 
                        'company'        => $this->request->post['shipping_company'], 
                        'address_1'      => $this->request->post['shipping_address_1'], 
                        'address_2'      => $this->request->post['shipping_address_2'], 
                        'postcode'       => $this->request->post['shipping_postcode'], 
                        'city'           => $this->request->post['shipping_city'], 
                        'zone_id'        => $this->request->post['shipping_zone_id'], 
                        'zone'           => $zone, 
                        'zone_code'      => $zone_code, 
                        'country_id'     => $this->request->post['shipping_country_id'], 
                        'country'        => $country, 
                        'iso_code_2'     => $iso_code_2, 
                        'iso_code_3'     => $iso_code_3, 
                        'address_format' => $address_format
                    );
                    
                    $results = SettingModule::getModules('shipping');
                    
                    foreach ($results as $result) {
                        if (Config::get($result['code'] . '_status')) {
                            Theme::model('shipping/' . $result['code']);
                            
                            $quote = $this->{'model_shipping_' . $result['code']}->getQuote($address_data);
                            
                            if ($quote) {
                                $json['shipping_method'][$result['code']] = array(
                                    'title'      => $quote['title'], 
                                    'quote'      => $quote['quote'], 
                                    'sort_order' => $quote['sort_order'], 
                                    'error'      => $quote['error']
                                );
                            }
                        }
                    }
                    
                    $sort_order = array();
                    
                    foreach ($json['shipping_method'] as $key => $value) {
                        $sort_order[$key] = $value['sort_order'];
                    }
                    
                    array_multisort($sort_order, SORT_ASC, $json['shipping_method']);
                    
                    if (!$json['shipping_method']) {
                        $json['error']['shipping_method'] = Lang::get('lang_error_no_shipping');
                    } elseif ($this->request->post['shipping_code']) {
                        $shipping = explode('.', $this->request->post['shipping_code']);
                        
                        if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($json['shipping_method'][$shipping[0]]['quote'][$shipping[1]])) {
                            $json['error']['shipping_method'] = Lang::get('lang_error_shipping');
                        } else {
                            $this->session->data['shipping_method'] = $json['shipping_method'][$shipping[0]]['quote'][$shipping[1]];
                        }
                    }
                }
            }
            
            // Coupon
            if (!empty($this->request->post['coupon'])) {
                Theme::model('checkout/coupon');
                
                $coupon_info = CheckoutCoupon::getCoupon($this->request->post['coupon']);
                
                if ($coupon_info) {
                    $this->session->data['coupon'] = $this->request->post['coupon'];
                } else {
                    $json['error']['coupon'] = Lang::get('lang_error_coupon');
                }
            }
            
            // Giftcard
            if (!empty($this->request->post['gift_card'])) {
                Theme::model('checkout/gift_card');
                
                $gift_card_info = CheckoutGiftCard::getGiftcard($this->request->post['gift_card']);
                
                if ($gift_card_info) {
                    $this->session->data['gift_card'] = $this->request->post['gift_card'];
                } else {
                    $json['error']['gift_card'] = Lang::get('lang_error_gift_card');
                }
            }
            
            // Reward Points
            if (!empty($this->request->post['reward'])) {
                $points = Customer::getRewardPoints();
                
                if ($this->request->post['reward'] > $points) {
                    $json['error']['reward'] = sprintf(Lang::get('lang_error_points'), $this->request->post['reward']);
                }
                
                if (!isset($json['error']['reward'])) {
                    $points_total = 0;
                    
                    foreach (Cart::getProducts() as $product) {
                        if ($product['points']) {
                            $points_total+= $product['points'];
                        }
                    }
                    
                    if ($this->request->post['reward'] > $points_total) {
                        $json['error']['reward'] = sprintf(Lang::get('lang_error_maximum'), $points_total);
                    }
                    
                    if (!isset($json['error']['reward'])) {
                        $this->session->data['reward'] = $this->request->post['reward'];
                    }
                }
            }
            
            // Totals
            $json['order_total'] = array();
            $total = 0;
            $taxes = Cart::getTaxes();
            
            $sort_order = array();
            
            $results = SettingModule::getModules('total');
            
            foreach ($results as $key => $value) {
                $sort_order[$key] = Config::get($value['code'] . '_sort_order');
            }
            
            array_multisort($sort_order, SORT_ASC, $results);
            
            foreach ($results as $result) {
                if (Config::get($result['code'] . '_status')) {
                    Theme::model('total/' . $result['code']);
                    
                    $this->{'model_total_' . $result['code']}->getTotal($json['order_total'], $total, $taxes);
                }
                
                $sort_order = array();
                
                foreach ($json['order_total'] as $key => $value) {
                    $sort_order[$key]                   = $value['sort_order'];
                    $json['order_total'][$key]['value'] = number_format($value['value'], 2);
                }
                
                array_multisort($sort_order, SORT_ASC, $json['order_total']);
            }
            
            // Payment
            if ($this->request->post['payment_country_id'] == '') {
                $json['error']['payment']['country'] = Lang::get('lang_error_country');
            }
            
            if (!isset($this->request->post['payment_zone_id']) || $this->request->post['payment_zone_id'] == '') {
                $json['error']['payment']['zone'] = Lang::get('lang_error_zone');
            }
            
            if (!isset($json['error']['payment'])) {
                $json['payment_methods'] = array();
                
                $country_info = LocaleCountry::getCountry($this->request->post['payment_country_id']);
                
                if ($country_info) {
                    $country        = $country_info['name'];
                    $iso_code_2     = $country_info['iso_code_2'];
                    $iso_code_3     = $country_info['iso_code_3'];
                    $address_format = $country_info['address_format'];
                } else {
                    $country        = '';
                    $iso_code_2     = '';
                    $iso_code_3     = '';
                    $address_format = '';
                }
                
                $zone_info = LocaleZone::getZone($this->request->post['payment_zone_id']);
                
                if ($zone_info) {
                    $zone = $zone_info['name'];
                    $zone_code = $zone_info['code'];
                } else {
                    $zone = '';
                    $zone_code = '';
                }
                
                $address_data = array(
                    'firstname'      => $this->request->post['payment_firstname'], 
                    'lastname'       => $this->request->post['payment_lastname'], 
                    'company'        => $this->request->post['payment_company'], 
                    'address_1'      => $this->request->post['payment_address_1'], 
                    'address_2'      => $this->request->post['payment_address_2'], 
                    'postcode'       => $this->request->post['payment_postcode'], 
                    'city'           => $this->request->post['payment_city'], 
                    'zone_id'        => $this->request->post['payment_zone_id'], 
                    'zone'           => $zone, 
                    'zone_code'      => $zone_code, 
                    'country_id'     => $this->request->post['payment_country_id'], 
                    'country'        => $country, 
                    'iso_code_2'     => $iso_code_2, 
                    'iso_code_3'     => $iso_code_3, 
                    'address_format' => $address_format
                );
                
                $json['payment_method'] = array();
                
                $results = SettingModule::getModules('payment');
                
                foreach ($results as $result) {
                    if (Config::get($result['code'] . '_status')) {
                        Theme::model('payment/' . $result['code']);
                        
                        $method = $this->{'model_payment_' . $result['code']}->getMethod($address_data, $total);
                        
                        if ($method) {
                            $json['payment_method'][$result['code']] = $method;
                        }
                    }
                }
                
                $sort_order = array();
                
                foreach ($json['payment_method'] as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }
                
                array_multisort($sort_order, SORT_ASC, $json['payment_method']);
                
                if (!$json['payment_method']) {
                    $json['error']['payment_method'] = Lang::get('lang_error_no_payment');
                } elseif ($this->request->post['payment_code']) {
                    if (!isset($json['payment_method'][$this->request->post['payment_code']])) {
                        $json['error']['payment_method'] = Lang::get('lang_error_payment');
                    }
                }
            }
            
            if (!isset($json['error'])) {
                $json['success'] = Lang::get('lang_text_success');
            } else {
                $json['error']['warning'] = Lang::get('lang_error_warning');
            }
            
            // Reset everything
            Cart::clear();
            Customer::logout();
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
        } else {
            $json['error']['warning'] = Lang::get('lang_error_permission');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
