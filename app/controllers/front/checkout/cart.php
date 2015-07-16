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

class Cart extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('checkout/cart');
        
        if (!isset($this->session->data['gift_cards'])) {
            $this->session->data['gift_cards'] = array();
        }
        
        // Update
        if (!empty($this->request->post['quantity'])) {
            foreach ($this->request->post['quantity'] as $key => $value) {
                Cart::update($key, $value);
            }
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['reward']);
            
            Response::redirect(Url::link('checkout/cart'));
        }
        
        // Remove
        if (isset($this->request->get['remove'])) {
            Cart::remove($this->request->get['remove']);
            
            unset($this->session->data['gift_cards'][$this->request->get['remove']]);
            
            $this->session->data['success'] = Lang::get('lang_text_remove');
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['reward']);
            
            Response::redirect(Url::link('checkout/cart'));
        }
        
        // Coupon
        if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
            $this->session->data['coupon'] = $this->request->post['coupon'];
            
            $this->session->data['success'] = Lang::get('lang_text_coupon');
            
            Response::redirect(Url::link('checkout/cart'));
        }
        
        // Gift card
        if (isset($this->request->post['gift_card']) && $this->validateGiftcard()) {
            $this->session->data['gift_card'] = $this->request->post['gift_card'];
            
            $this->session->data['success'] = Lang::get('lang_text_gift_card');
            
            Response::redirect(Url::link('checkout/cart'));
        }
        
        // Reward
        if (isset($this->request->post['reward']) && $this->validateReward()) {
            $this->session->data['reward'] = abs($this->request->post['reward']);
            
            $this->session->data['success'] = Lang::get('lang_text_reward');
            
            Response::redirect(Url::link('checkout/cart'));
        }
        
        // Shipping
        if (isset($this->request->post['shipping_method']) && $this->validateShipping()) {
            $shipping = explode('.', $this->request->post['shipping_method']);
            
            $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
            
            $this->session->data['success'] = Lang::get('lang_text_shipping');
            
            Response::redirect(Url::link('checkout/cart'));
        }
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_heading_title', 'checkout/cart');
        
        if (Cart::hasProducts() || !empty($this->session->data['gift_cards'])) {
            $points = Customer::getRewardPoints();
            
            $points_total = 0;
            
            foreach (Cart::getProducts() as $product) {
                if ($product['points']) {
                    $points_total+= $product['points'];
                }
            }
            
            $data['text_use_reward'] = sprintf(Lang::get('lang_text_use_reward'), $points);
            $data['entry_reward'] = sprintf(Lang::get('lang_entry_reward'), $points_total);
            
            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } elseif (!Cart::hasStock() && (!Config::get('config_stock_checkout') || Config::get('config_stock_warning'))) {
                $data['error_warning'] = Lang::get('lang_error_stock');
            } else {
                $data['error_warning'] = '';
            }
            
            if (Config::get('config_customer_price') && !Customer::isLogged()) {
                $data['attention'] = sprintf(Lang::get('lang_text_login'), Url::link('account/login'), Url::link('account/register'));
            } else {
                $data['attention'] = '';
            }
            
            if (isset($this->session->data['success'])) {
                $data['success'] = $this->session->data['success'];
                
                unset($this->session->data['success']);
            } else {
                $data['success'] = '';
            }
            
            $data['action'] = Url::link('checkout/cart');
            
            if (Config::get('config_cart_weight')) {
                $data['weight'] = $this->weight->format(Cart::getWeight(), Config::get('config_weight_class_id'), Lang::get('lang_decimal_point'), Lang::get('lang_thousand_point'));
            } else {
                $data['weight'] = '';
            }
            
            Theme::model('tool/image');
            
            $data['products'] = array();
            
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
                        
                        $value = Encode::substr($filename, 0, Encode::strrpos($filename, '.'));
                    }
                    
                    $option_data[] = array(
                        'name' => $option['name'], 
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
                
                $recurring = '';
                
                if ($product['recurring']) {
                    $frequencies = array(
                        'day'        => Lang::get('lang_text_day'), 
                        'week'       => Lang::get('lang_text_week'), 
                        'semi_month' => Lang::get('lang_text_semi_month'), 
                        'month'      => Lang::get('lang_text_month'), 
                        'year'       => Lang::get('lang_text_year')
                    );
                    
                    if ($product['recurring']['trial']) {
                        $recurring = sprintf(Lang::get('lang_text_trial_description'), Currency::format(Tax::calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }
                    
                    if ($product['recurring']['duration']) {
                        $recurring.= sprintf(Lang::get('lang_text_payment_description'), Currency::format(Tax::calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring.= sprintf(Lang::get('lang_text_payment_until_canceled_description'), Currency::format(Tax::calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], Config::get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }
                
                $remove_url = Url::link('checkout/cart', 'remove=' . $product['key']);
                
                $data['products'][] = array(
                    'key'       => $product['key'], 
                    'thumb'     => $image, 
                    'name'      => $product['name'], 
                    'model'     => $product['model'], 
                    'option'    => $option_data, 
                    'quantity'  => $product['quantity'], 
                    'stock'     => $product['stock'] ? true : !(!Config::get('config_stock_checkout') || Config::get('config_stock_warning')), 
                    'reward'    => ($product['reward'] ? sprintf(Lang::get('lang_text_points'), $product['reward']) : ''), 
                    'price'     => $price, 
                    'total'     => $total, 
                    'href'      => Url::link('catalog/product', 'product_id=' . $product['product_id']), 
                    'remove'    => urldecode($remove_url), 
                    'recurring' => $recurring
                );
            }
            
            // Gift card
            $data['gift_cards'] = array();
            
            if (!empty($this->session->data['gift_cards'])) {
                foreach ($this->session->data['gift_cards'] as $key => $gift_card) {
                    $data['gift_cards'][] = array(
                        'key' => $key, 
                        'description' => $gift_card['description'], 
                        'amount' => Currency::format($gift_card['amount']), 
                        'remove' => Url::link('checkout/cart', 'remove=' . $key)
                    );
                }
            }
            
            if (isset($this->request->post['next'])) {
                $data['next'] = $this->request->post['next'];
            } else {
                $data['next'] = '';
            }
            
            $data['coupon_status'] = Config::get('coupon_status');
            
            if (isset($this->request->post['coupon'])) {
                $data['coupon'] = $this->request->post['coupon'];
            } elseif (isset($this->session->data['coupon'])) {
                $data['coupon'] = $this->session->data['coupon'];
            } else {
                $data['coupon'] = '';
            }
            
            $data['gift_card_status'] = Config::get('gift_card_status');
            
            if (isset($this->request->post['gift_card'])) {
                $data['gift_card'] = $this->request->post['gift_card'];
            } elseif (isset($this->session->data['gift_card'])) {
                $data['gift_card'] = $this->session->data['gift_card'];
            } else {
                $data['gift_card'] = '';
            }
            
            $data['reward_status'] = ($points && $points_total && Config::get('reward_status'));
            
            if (isset($this->request->post['reward'])) {
                $data['reward'] = $this->request->post['reward'];
            } elseif (isset($this->session->data['reward'])) {
                $data['reward'] = $this->session->data['reward'];
            } else {
                $data['reward'] = '';
            }
            
            $data['shipping_status'] = Config::get('shipping_status') && Config::get('shipping_estimator') && Cart::hasShipping();
            
            if (isset($this->request->post['country_id'])) {
                $data['country_id'] = $this->request->post['country_id'];
            } elseif (isset($this->session->data['shipping_country_id'])) {
                $data['country_id'] = $this->session->data['shipping_country_id'];
            } else {
                $data['country_id'] = Config::get('config_country_id');
            }
            
            Theme::model('locale/country');
            
            $data['countries'] = LocaleCountry::getCountries();
            
            if (isset($this->request->post['zone_id'])) {
                $data['zone_id'] = $this->request->post['zone_id'];
            } elseif (isset($this->session->data['shipping_zone_id'])) {
                $data['zone_id'] = $this->session->data['shipping_zone_id'];
            } else {
                $data['zone_id'] = '';
            }
            
            $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
            
            if (isset($this->request->post['postcode'])) {
                $data['postcode'] = $this->request->post['postcode'];
            } elseif (isset($this->session->data['shipping_postcode'])) {
                $data['postcode'] = $this->session->data['shipping_postcode'];
            } else {
                $data['postcode'] = '';
            }
            
            if (isset($this->request->post['shipping_method'])) {
                $data['shipping_method'] = $this->request->post['shipping_method'];
            } elseif (isset($this->session->data['shipping_method'])) {
                $data['shipping_method'] = $this->session->data['shipping_method']['code'];
            } else {
                $data['shipping_method'] = '';
            }
            
            // Totals
            Theme::model('setting/module');
            
            $total_data = array();
            $total = 0;
            $taxes = Cart::getTaxes();
            
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
                    
                    $sort_order = array();
                    
                    foreach ($total_data as $key => $value) {
                        $sort_order[$key] = $value['sort_order'];
                    }
                    
                    array_multisort($sort_order, SORT_ASC, $total_data);
                }
            }
            
            $data['totals'] = $total_data;
            
            $data['continue'] = Url::link('shop/home');
            
            $data['checkout'] = Url::link('checkout/checkout', '', 'SSL');
            
            Theme::model('setting/module');
            
            $data['checkout_buttons'] = array();
            
            Theme::loadjs('javascript/checkout/cart', $data);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::render('checkout/cart', $data));
        } else {
            Theme::setTitle(Lang::get('lang_heading_title'));
            
			$data['heading_title'] = Lang::get('lang_heading_title');
			
			$data['text_error'] = Lang::get('lang_text_empty');
            
            $data['continue'] = Url::link('shop/home');
            
            unset($this->session->data['success']);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::render('error/not_found', $data));
        }
    }
    
    protected function validateCoupon() {
        Theme::model('checkout/coupon');
        
        $coupon_info = CheckoutCoupon::getCoupon($this->request->post['coupon']);
        
        if (!$coupon_info) {
            $this->error['warning'] = Lang::get('lang_error_coupon');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateGiftcard() {
        Theme::model('checkout/gift_card');
        
        $gift_card_info = CheckoutGiftCard::getGiftcard($this->request->post['gift_card']);
        
        if (!$gift_card_info) {
            $this->error['warning'] = Lang::get('lang_error_gift_card');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateReward() {
        $points = Customer::getRewardPoints();
        
        $points_total = 0;
        
        foreach (Cart::getProducts() as $product) {
            if ($product['points']) {
                $points_total+= $product['points'];
            }
        }
        
        if (empty($this->request->post['reward'])) {
            $this->error['warning'] = Lang::get('lang_error_reward');
        }
        
        if ($this->request->post['reward'] > $points) {
            $this->error['warning'] = sprintf(Lang::get('lang_error_points'), $this->request->post['reward']);
        }
        
        if ($this->request->post['reward'] > $points_total) {
            $this->error['warning'] = sprintf(Lang::get('lang_error_maximum'), $points_total);
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateShipping() {
        if (!empty($this->request->post['shipping_method'])) {
            $shipping = explode('.', $this->request->post['shipping_method']);
            
            if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                $this->error['warning'] = Lang::get('lang_error_shipping');
            }
        } else {
            $this->error['warning'] = Lang::get('lang_error_shipping');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function add() {
        Theme::language('checkout/cart');
        
        $json = array();
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        Theme::model('catalog/product');
        
        // this is a custom piece for private products
        if (isset($this->request->post['cp']) && $this->request->post['cp'] == 1):
            Theme::model('account/product');
            $product_info = AccountProduct::getProduct($product_id, Customer::getId());
        else:
            $product_info = CatalogProduct::getProduct($product_id);
        endif;
        
        if ($product_info) {
            if (isset($this->request->post['quantity'])) {
                $quantity = $this->request->post['quantity'];
            } else {
                $quantity = 1;
            }
            
            if (isset($this->request->post['event_id'])):
                $json['redirect'] = Url::link('catalog/product', 'product_id=' . $product_id);
            endif;
            
            if (isset($this->request->post['option'])) {
                $option = array_filter($this->request->post['option']);
            } else {
                $option = array();
            }
            
            $product_options = CatalogProduct::getProductOptions($this->request->post['product_id']);
            
            foreach ($product_options as $product_option) {
                if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                    $json['error']['option'][$product_option['product_option_id']] = sprintf(Lang::get('lang_error_required'), $product_option['name']);
                }
            }
            
            if (isset($this->request->post['recurring_id'])) {
                $recurring_id = $this->request->post['recurring_id'];
            } else {
                $recurring_id = 0;
            }
            
            $recurrings = CatalogProduct::getAllRecurring($product_info['product_id']);
            
            if ($recurrings) {
                $recurring_ids = array();
                
                foreach ($recurrings as $recurring) {
                    $recurring_ids[] = $recurring['recurring_id'];
                }
                
                if (!in_array($recurring_id, $recurring_ids)) {
                    $json['error']['recurring'] = Lang::get('lang_error_recurring_required');
                }
            }
            
            if (!$json) {
                Cart::add($this->request->post['product_id'], $quantity, $option, $recurring_id);
                
                $json['success'] = sprintf(Lang::get('lang_text_success'), Url::link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], Url::link('checkout/cart'));
                
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
                
                // Totals
                Theme::model('setting/module');
                
                $total_data = array();
                $total = 0;
                $taxes = Cart::getTaxes();
                
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
                        
                        $sort_order = array();
                        
                        foreach ($total_data as $key => $value) {
                            $sort_order[$key] = $value['sort_order'];
                        }
                        
                        array_multisort($sort_order, SORT_ASC, $total_data);
                    }
                }
                
                $json['total'] = sprintf(Lang::get('lang_text_items'), Cart::countProducts() + (isset($this->session->data['gift_cards']) ? count($this->session->data['gift_cards']) : 0), Currency::format($total));
            } else {
                $json['redirect'] = str_replace('&amp;', '&', Url::link('catalog/product', 'product_id=' . $this->request->post['product_id']));
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function remove() {
        Theme::language('checkout/cart');
        
        $json = array();
        
        // Remove
        if (isset($this->request->post['remove'])) {
            Cart::remove($this->request->post['remove']);
            
            unset($this->session->data['gift_cards'][$this->request->post['remove']]);
            
            $this->session->data['success'] = Lang::get('lang_text_remove');
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['reward']);
            
            // Totals
            Theme::model('setting/module');
            
            $total_data = array();
            $total = 0;
            $taxes = Cart::getTaxes();
            
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
            
            $json['total'] = sprintf(Lang::get('lang_text_items'), Cart::countProducts() + (isset($this->session->data['gift_cards']) ? count($this->session->data['gift_cards']) : 0), Currency::format($total));
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function quote() {
        Theme::language('checkout/cart');
        
        $json = array();
        
        if (!Cart::hasProducts()) {
            $json['error']['warning'] = Lang::get('lang_error_product');
        }
        
        if (!Cart::hasShipping()) {
            $json['error']['warning'] = sprintf(Lang::get('lang_error_no_shipping'), Url::link('content/contact'));
        }
        
        if ($this->request->post['country_id'] == '') {
            $json['error']['country'] = Lang::get('lang_error_country');
        }
        
        if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
            $json['error']['zone'] = Lang::get('lang_error_zone');
        }
        
        Theme::model('locale/country');
        
        $country_info = LocaleCountry::getCountry($this->request->post['country_id']);
        
        if ($country_info && $country_info['postcode_required'] && (Encode::strlen($this->request->post['postcode']) < 2) || (Encode::strlen($this->request->post['postcode']) > 10)) {
            $json['error']['postcode'] = Lang::get('lang_error_postcode');
        }
        
        if (!$json) {
            Tax::setShippingAddress($this->request->post['country_id'], $this->request->post['zone_id']);
            
            // Default Shipping Address
            $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
            $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
            $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
            
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
            
            Theme::model('locale/zone');
            
            $zone_info = LocaleZone::getZone($this->request->post['zone_id']);
            
            if ($zone_info) {
                $zone = $zone_info['name'];
                $zone_code = $zone_info['code'];
            } else {
                $zone = '';
                $zone_code = '';
            }
            
            $address_data = array(
                'firstname'      => '', 
                'lastname'       => '', 
                'company'        => '', 
                'address_1'      => '', 
                'address_2'      => '', 
                'postcode'       => $this->request->post['postcode'], 
                'city'           => '', 
                'zone_id'        => $this->request->post['zone_id'], 
                'zone'           => $zone, 
                'zone_code'      => $zone_code, 
                'country_id'     => $this->request->post['country_id'], 
                'country'        => $country, 
                'iso_code_2'     => $iso_code_2, 
                'iso_code_3'     => $iso_code_3, 
                'address_format' => $address_format
            );
            
            $quote_data = array();
            
            Theme::model('setting/module');
            
            $results = SettingModule::getModules('shipping');
            
            foreach ($results as $result) {
                if (Config::get($result['code'] . '_status')) {
                    Theme::model('shipping/' . $result['code']);
                    
                    $quote = $this->{'model_shipping_' . $result['code']}->getQuote($address_data);
                    
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
            
            $sort_order = array();
            
            foreach ($quote_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }
            
            array_multisort($sort_order, SORT_ASC, $quote_data);
            
            $this->session->data['shipping_methods'] = $quote_data;
            
            if ($this->session->data['shipping_methods']) {
                $json['shipping_method'] = $this->session->data['shipping_methods'];
            } else {
                $json['error']['warning'] = sprintf(Lang::get('lang_error_no_shipping'), Url::link('content/contact'));
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function country() {
        $json = array();
        
        Theme::model('locale/country');
        
        $country_info = LocaleCountry::getCountry($this->request->get['country_id']);
        
        if ($country_info) {
            Theme::model('locale/zone');
            
            $json = array(
                'country_id'        => $country_info['country_id'], 
                'name'              => $country_info['name'], 
                'iso_code_2'        => $country_info['iso_code_2'], 
                'iso_code_3'        => $country_info['iso_code_3'], 
                'address_format'    => $country_info['address_format'], 
                'postcode_required' => $country_info['postcode_required'], 
                'zone'              => LocaleZone::getZonesByCountryId($this->request->get['country_id']), 
                'status'            => $country_info['status']
            );
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
