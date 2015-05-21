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
use Dais\Library\User;

class Manual extends Controller {
    public function index() {
        $this->theme->language('checkout/manual');
        
        $json = array();
        
        $this->user = new User($this->app);
        $this->user->login($this->config->get('config_admin_email_user'), '', true);
        
        if ($this->user->isLogged() && $this->user->hasPermission('modify', 'sale/order')) {
            
            // Reset everything
            $this->cart->clear();
            $this->customer->logout();
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
            
            // Settings
            $this->theme->model('setting/setting');
            
            $settings = $this->model_setting_setting->getSetting('config', $this->request->post['store_id']);
            
            foreach ($settings as $key => $value) {
                $this->config->set($key, $value);
            }
            
            // Customer
            if ($this->request->post['customer_id']) {
                $this->theme->model('account/customer');
                
                $customer_info = $this->model_account_customer->getCustomer($this->request->post['customer_id']);
                
                if ($customer_info) {
                    $this->customer->login($customer_info['email'], '', true);
                    $this->cart->clear();
                } else {
                    $json['error']['customer'] = $this->language->get('lang_error_customer');
                }
            } else {
                
                // Customer Group
                $this->config->set('config_customer_group_id', $this->request->post['customer_group_id']);
            }
            
            // Product
            $this->theme->model('catalog/product');
            
            if (isset($this->request->post['order_product'])) {
                foreach ($this->request->post['order_product'] as $order_product) {
                    $product_info = $this->model_catalog_product->getProduct($order_product['product_id']);
                    
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
                        
                        $this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
                    }
                }
            }
            
            if (isset($this->request->post['product_id'])) {
                $product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);
                
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
                    
                    $product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
                    
                    foreach ($product_options as $product_option) {
                        if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                            $json['error']['product']['option'][$product_option['product_option_id']] = sprintf($this->language->get('lang_error_required'), $product_option['name']);
                        }
                    }
                    
                    if (!isset($json['error']['product']['option'])) {
                        $this->cart->add($this->request->post['product_id'], $quantity, $option);
                    }
                }
            }
            
            // Stock
            if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
                $json['error']['product']['stock'] = $this->language->get('lang_error_stock');
            }
            
            // Tax
            if ($this->cart->hasShipping()) {
                $this->tax->setShippingAddress($this->request->post['shipping_country_id'], $this->request->post['shipping_zone_id']);
            } else {
                $this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
            }
            
            $this->tax->setPaymentAddress($this->request->post['payment_country_id'], $this->request->post['payment_zone_id']);
            $this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
            
            // Products
            $json['order_product'] = array();
            
            $products = $this->cart->getProducts();
            
            foreach ($products as $product) {
                $product_total = 0;
                
                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total+= $product_2['quantity'];
                    }
                }
                
                if ($product['minimum'] > $product_total) {
                    $json['error']['product']['minimum'][] = sprintf($this->language->get('lang_error_minimum'), $product['name'], $product['minimum']);
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
                    'tax'        => number_format($this->tax->getTax($product['price'], $product['tax_class_id']), 2), 
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
                if (($this->encode->strlen($this->request->post['from_name']) < 1) || ($this->encode->strlen($this->request->post['from_name']) > 64)) {
                    $json['error']['gift_cards']['from_name'] = $this->language->get('lang_error_from_name');
                }
                
                if (($this->encode->strlen($this->request->post['from_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['from_email'])) {
                    $json['error']['gift_cards']['from_email'] = $this->language->get('lang_error_email');
                }
                
                if (($this->encode->strlen($this->request->post['to_name']) < 1) || ($this->encode->strlen($this->request->post['to_name']) > 64)) {
                    $json['error']['gift_cards']['to_name'] = $this->language->get('lang_error_to_name');
                }
                
                if (($this->encode->strlen($this->request->post['to_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['to_email'])) {
                    $json['error']['gift_cards']['to_email'] = $this->language->get('lang_error_email');
                }
                
                if (($this->request->post['amount'] < 1) || ($this->request->post['amount'] > 1000)) {
                    $json['error']['gift_cards']['amount'] = sprintf($this->language->get('lang_error_amount'), $this->currency->format(1, false, 1), $this->currency->format(1000, false, 1) . ' ' . $this->config->get('config_currency'));
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
                    
                    $this->theme->model('checkout/gift_card');
                    
                    $gift_card_id = $this->model_checkout_gift_card->addGiftcard(0, $gift_card_data);
                    
                    $this->session->data['gift_cards'][] = array(
                        'gift_card_id'       => $gift_card_id, 
                        'description'       => sprintf($this->language->get('lang_text_for'), $this->currency->format($this->request->post['amount'], $this->config->get('config_currency')), $this->request->post['to_name']), 
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
            
            $this->theme->model('setting/module');
            
            $this->theme->model('localization/country');
            
            $this->theme->model('localization/zone');
            
            // Shipping
            $json['shipping_method'] = array();
            
            if ($this->cart->hasShipping()) {
                $this->theme->model('localization/country');
                
                $country_info = $this->model_localization_country->getCountry($this->request->post['shipping_country_id']);
                
                if ($country_info && $country_info['postcode_required'] && ($this->encode->strlen($this->request->post['shipping_postcode']) < 2) || ($this->encode->strlen($this->request->post['shipping_postcode']) > 10)) {
                    $json['error']['shipping']['postcode'] = $this->language->get('lang_error_postcode');
                }
                
                if ($this->request->post['shipping_country_id'] == '') {
                    $json['error']['shipping']['country'] = $this->language->get('lang_error_country');
                }
                
                if (!isset($this->request->post['shipping_zone_id']) || $this->request->post['shipping_zone_id'] == '') {
                    $json['error']['shipping']['zone'] = $this->language->get('lang_error_zone');
                }
                
                $this->theme->model('localization/country');
                
                $country_info = $this->model_localization_country->getCountry($this->request->post['shipping_country_id']);
                
                if ($country_info && $country_info['postcode_required'] && ($this->encode->strlen($this->request->post['shipping_postcode']) < 2) || ($this->encode->strlen($this->request->post['shipping_postcode']) > 10)) {
                    $json['error']['shipping']['postcode'] = $this->language->get('lang_error_postcode');
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
                    
                    $zone_info = $this->model_localization_zone->getZone($this->request->post['shipping_zone_id']);
                    
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
                    
                    $results = $this->model_setting_module->getModules('shipping');
                    
                    foreach ($results as $result) {
                        if ($this->config->get($result['code'] . '_status')) {
                            $this->theme->model('shipping/' . $result['code']);
                            
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
                        $json['error']['shipping_method'] = $this->language->get('lang_error_no_shipping');
                    } elseif ($this->request->post['shipping_code']) {
                        $shipping = explode('.', $this->request->post['shipping_code']);
                        
                        if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($json['shipping_method'][$shipping[0]]['quote'][$shipping[1]])) {
                            $json['error']['shipping_method'] = $this->language->get('lang_error_shipping');
                        } else {
                            $this->session->data['shipping_method'] = $json['shipping_method'][$shipping[0]]['quote'][$shipping[1]];
                        }
                    }
                }
            }
            
            // Coupon
            if (!empty($this->request->post['coupon'])) {
                $this->theme->model('checkout/coupon');
                
                $coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);
                
                if ($coupon_info) {
                    $this->session->data['coupon'] = $this->request->post['coupon'];
                } else {
                    $json['error']['coupon'] = $this->language->get('lang_error_coupon');
                }
            }
            
            // Giftcard
            if (!empty($this->request->post['gift_card'])) {
                $this->theme->model('checkout/gift_card');
                
                $gift_card_info = $this->model_checkout_gift_card->getGiftcard($this->request->post['gift_card']);
                
                if ($gift_card_info) {
                    $this->session->data['gift_card'] = $this->request->post['gift_card'];
                } else {
                    $json['error']['gift_card'] = $this->language->get('lang_error_gift_card');
                }
            }
            
            // Reward Points
            if (!empty($this->request->post['reward'])) {
                $points = $this->customer->getRewardPoints();
                
                if ($this->request->post['reward'] > $points) {
                    $json['error']['reward'] = sprintf($this->language->get('lang_error_points'), $this->request->post['reward']);
                }
                
                if (!isset($json['error']['reward'])) {
                    $points_total = 0;
                    
                    foreach ($this->cart->getProducts() as $product) {
                        if ($product['points']) {
                            $points_total+= $product['points'];
                        }
                    }
                    
                    if ($this->request->post['reward'] > $points_total) {
                        $json['error']['reward'] = sprintf($this->language->get('lang_error_maximum'), $points_total);
                    }
                    
                    if (!isset($json['error']['reward'])) {
                        $this->session->data['reward'] = $this->request->post['reward'];
                    }
                }
            }
            
            // Totals
            $json['order_total'] = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();
            
            $sort_order = array();
            
            $results = $this->model_setting_module->getModules('total');
            
            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }
            
            array_multisort($sort_order, SORT_ASC, $results);
            
            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->theme->model('total/' . $result['code']);
                    
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
                $json['error']['payment']['country'] = $this->language->get('lang_error_country');
            }
            
            if (!isset($this->request->post['payment_zone_id']) || $this->request->post['payment_zone_id'] == '') {
                $json['error']['payment']['zone'] = $this->language->get('lang_error_zone');
            }
            
            if (!isset($json['error']['payment'])) {
                $json['payment_methods'] = array();
                
                $country_info = $this->model_localization_country->getCountry($this->request->post['payment_country_id']);
                
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
                
                $zone_info = $this->model_localization_zone->getZone($this->request->post['payment_zone_id']);
                
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
                
                $results = $this->model_setting_module->getModules('payment');
                
                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->theme->model('payment/' . $result['code']);
                        
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
                    $json['error']['payment_method'] = $this->language->get('lang_error_no_payment');
                } elseif ($this->request->post['payment_code']) {
                    if (!isset($json['payment_method'][$this->request->post['payment_code']])) {
                        $json['error']['payment_method'] = $this->language->get('lang_error_payment');
                    }
                }
            }
            
            if (!isset($json['error'])) {
                $json['success'] = $this->language->get('lang_text_success');
            } else {
                $json['error']['warning'] = $this->language->get('lang_error_warning');
            }
            
            // Reset everything
            $this->cart->clear();
            $this->customer->logout();
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
        } else {
            $json['error']['warning'] = $this->language->get('lang_error_permission');
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
