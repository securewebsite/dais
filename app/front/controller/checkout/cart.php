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
use Dais\Base\Controller;

class Cart extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('checkout/cart');
        
        if (!isset($this->session->data['gift_cards'])) {
            $this->session->data['gift_cards'] = array();
        }
        
        // Update
        if (!empty($this->request->post['quantity'])) {
            foreach ($this->request->post['quantity'] as $key => $value) {
                $this->cart->update($key, $value);
            }
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['reward']);
            
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        
        // Remove
        if (isset($this->request->get['remove'])) {
            $this->cart->remove($this->request->get['remove']);
            
            unset($this->session->data['gift_cards'][$this->request->get['remove']]);
            
            $this->session->data['success'] = $this->language->get('lang_text_remove');
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['reward']);
            
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        
        // Coupon
        if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
            $this->session->data['coupon'] = $this->request->post['coupon'];
            
            $this->session->data['success'] = $this->language->get('lang_text_coupon');
            
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        
        // Gift card
        if (isset($this->request->post['gift_card']) && $this->validateGiftcard()) {
            $this->session->data['gift_card'] = $this->request->post['gift_card'];
            
            $this->session->data['success'] = $this->language->get('lang_text_gift_card');
            
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        
        // Reward
        if (isset($this->request->post['reward']) && $this->validateReward()) {
            $this->session->data['reward'] = abs($this->request->post['reward']);
            
            $this->session->data['success'] = $this->language->get('lang_text_reward');
            
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        
        // Shipping
        if (isset($this->request->post['shipping_method']) && $this->validateShipping()) {
            $shipping = explode('.', $this->request->post['shipping_method']);
            
            $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
            
            $this->session->data['success'] = $this->language->get('lang_text_shipping');
            
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_heading_title', 'checkout/cart');
        
        if ($this->cart->hasProducts() || !empty($this->session->data['gift_cards'])) {
            $points = $this->customer->getRewardPoints();
            
            $points_total = 0;
            
            foreach ($this->cart->getProducts() as $product) {
                if ($product['points']) {
                    $points_total+= $product['points'];
                }
            }
            
            $data['text_use_reward'] = sprintf($this->language->get('lang_text_use_reward'), $points);
            $data['entry_reward'] = sprintf($this->language->get('lang_entry_reward'), $points_total);
            
            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } elseif (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
                $data['error_warning'] = $this->language->get('lang_error_stock');
            } else {
                $data['error_warning'] = '';
            }
            
            if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
                $data['attention'] = sprintf($this->language->get('lang_text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
            } else {
                $data['attention'] = '';
            }
            
            if (isset($this->session->data['success'])) {
                $data['success'] = $this->session->data['success'];
                
                unset($this->session->data['success']);
            } else {
                $data['success'] = '';
            }
            
            $data['action'] = $this->url->link('checkout/cart');
            
            if ($this->config->get('config_cart_weight')) {
                $data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('lang_decimal_point'), $this->language->get('lang_thousand_point'));
            } else {
                $data['weight'] = '';
            }
            
            $this->theme->model('tool/image');
            
            $data['products'] = array();
            
            $products = $this->cart->getProducts();
            
            foreach ($products as $product) {
                $product_total = 0;
                
                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total+= $product_2['quantity'];
                    }
                }
                
                if ($product['minimum'] > $product_total) {
                    $data['error_warning'] = sprintf($this->language->get('lang_error_minimum'), $product['name'], $product['minimum']);
                }
                
                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                } else {
                    $image = '';
                }
                
                $option_data = array();
                
                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $filename = $this->encryption->decrypt($option['option_value']);
                        
                        $value = $this->encode->substr($filename, 0, $this->encode->strrpos($filename, '.'));
                    }
                    
                    $option_data[] = array(
                        'name' => $option['name'], 
                        'value' => ($this->encode->strlen($value) > 20 ? $this->encode->substr($value, 0, 20) . '..' : $value)
                    );
                }
                
                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }
                
                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
                } else {
                    $total = false;
                }
                
                $recurring = '';
                
                if ($product['recurring']) {
                    $frequencies = array(
                        'day'        => $this->language->get('lang_text_day'), 
                        'week'       => $this->language->get('lang_text_week'), 
                        'semi_month' => $this->language->get('lang_text_semi_month'), 
                        'month'      => $this->language->get('lang_text_month'), 
                        'year'       => $this->language->get('lang_text_year')
                    );
                    
                    if ($product['recurring']['trial']) {
                        $recurring = sprintf($this->language->get('lang_text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }
                    
                    if ($product['recurring']['duration']) {
                        $recurring.= sprintf($this->language->get('lang_text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring.= sprintf($this->language->get('lang_text_payment_until_canceled_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }
                
                $remove_url = $this->url->link('checkout/cart', 'remove=' . $product['key']);
                
                $data['products'][] = array(
                    'key'       => $product['key'], 
                    'thumb'     => $image, 
                    'name'      => $product['name'], 
                    'model'     => $product['model'], 
                    'option'    => $option_data, 
                    'quantity'  => $product['quantity'], 
                    'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')), 
                    'reward'    => ($product['reward'] ? sprintf($this->language->get('lang_text_points'), $product['reward']) : ''), 
                    'price'     => $price, 
                    'total'     => $total, 
                    'href'      => $this->url->link('catalog/product', 'product_id=' . $product['product_id']), 
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
                        'amount' => $this->currency->format($gift_card['amount']), 
                        'remove' => $this->url->link('checkout/cart', 'remove=' . $key)
                    );
                }
            }
            
            if (isset($this->request->post['next'])) {
                $data['next'] = $this->request->post['next'];
            } else {
                $data['next'] = '';
            }
            
            $data['coupon_status'] = $this->config->get('coupon_status');
            
            if (isset($this->request->post['coupon'])) {
                $data['coupon'] = $this->request->post['coupon'];
            } elseif (isset($this->session->data['coupon'])) {
                $data['coupon'] = $this->session->data['coupon'];
            } else {
                $data['coupon'] = '';
            }
            
            $data['gift_card_status'] = $this->config->get('gift_card_status');
            
            if (isset($this->request->post['gift_card'])) {
                $data['gift_card'] = $this->request->post['gift_card'];
            } elseif (isset($this->session->data['gift_card'])) {
                $data['gift_card'] = $this->session->data['gift_card'];
            } else {
                $data['gift_card'] = '';
            }
            
            $data['reward_status'] = ($points && $points_total && $this->config->get('reward_status'));
            
            if (isset($this->request->post['reward'])) {
                $data['reward'] = $this->request->post['reward'];
            } elseif (isset($this->session->data['reward'])) {
                $data['reward'] = $this->session->data['reward'];
            } else {
                $data['reward'] = '';
            }
            
            $data['shipping_status'] = $this->config->get('shipping_status') && $this->config->get('shipping_estimator') && $this->cart->hasShipping();
            
            if (isset($this->request->post['country_id'])) {
                $data['country_id'] = $this->request->post['country_id'];
            } elseif (isset($this->session->data['shipping_country_id'])) {
                $data['country_id'] = $this->session->data['shipping_country_id'];
            } else {
                $data['country_id'] = $this->config->get('config_country_id');
            }
            
            $this->theme->model('localization/country');
            
            $data['countries'] = $this->model_localization_country->getCountries();
            
            if (isset($this->request->post['zone_id'])) {
                $data['zone_id'] = $this->request->post['zone_id'];
            } elseif (isset($this->session->data['shipping_zone_id'])) {
                $data['zone_id'] = $this->session->data['shipping_zone_id'];
            } else {
                $data['zone_id'] = '';
            }
            
            $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . $this->language->get('lang_text_select') . '","none":"' . $this->language->get('lang_text_none') . '"}');
            
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
            $this->theme->model('setting/module');
            
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();
            
            // Display prices
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $sort_order = array();
                
                $results = $this->model_setting_module->getModules('total');
                
                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                }
                
                array_multisort($sort_order, SORT_ASC, $results);
                
                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->theme->model('total/' . $result['code']);
                        
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
            
            $data['continue'] = $this->url->link('shop/home');
            
            $data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
            
            $this->theme->model('setting/module');
            
            $data['checkout_buttons'] = array();
            
            $this->theme->loadjs('javascript/checkout/cart', $data);
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $this->theme->set_controller('header', 'shop/header');
            $this->theme->set_controller('footer', 'shop/footer');
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('checkout/cart', $data));
        } else {
            $this->theme->setTitle($this->language->get('lang_heading_title'));
            
			$data['heading_title'] = $this->language->get('lang_heading_title');
			
			$data['text_error'] = $this->language->get('lang_text_empty');
            
            $data['continue'] = $this->url->link('shop/home');
            
            unset($this->session->data['success']);
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $this->theme->set_controller('header', 'shop/header');
            $this->theme->set_controller('footer', 'shop/footer');
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('error/not_found', $data));
        }
    }
    
    protected function validateCoupon() {
        $this->theme->model('checkout/coupon');
        
        $coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);
        
        if (!$coupon_info) {
            $this->error['warning'] = $this->language->get('lang_error_coupon');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateGiftcard() {
        $this->theme->model('checkout/gift_card');
        
        $gift_card_info = $this->model_checkout_gift_card->getGiftcard($this->request->post['gift_card']);
        
        if (!$gift_card_info) {
            $this->error['warning'] = $this->language->get('lang_error_gift_card');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateReward() {
        $points = $this->customer->getRewardPoints();
        
        $points_total = 0;
        
        foreach ($this->cart->getProducts() as $product) {
            if ($product['points']) {
                $points_total+= $product['points'];
            }
        }
        
        if (empty($this->request->post['reward'])) {
            $this->error['warning'] = $this->language->get('lang_error_reward');
        }
        
        if ($this->request->post['reward'] > $points) {
            $this->error['warning'] = sprintf($this->language->get('lang_error_points'), $this->request->post['reward']);
        }
        
        if ($this->request->post['reward'] > $points_total) {
            $this->error['warning'] = sprintf($this->language->get('lang_error_maximum'), $points_total);
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateShipping() {
        if (!empty($this->request->post['shipping_method'])) {
            $shipping = explode('.', $this->request->post['shipping_method']);
            
            if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                $this->error['warning'] = $this->language->get('lang_error_shipping');
            }
        } else {
            $this->error['warning'] = $this->language->get('lang_error_shipping');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function add() {
        $this->theme->language('checkout/cart');
        
        $json = array();
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        $this->theme->model('catalog/product');
        
        // this is a custom piece for private products
        if (isset($this->request->post['cp']) && $this->request->post['cp'] == 1):
            $this->theme->model('account/product');
            $product_info = $this->model_account_product->getProduct($product_id, $this->customer->getId());
        else:
            $product_info = $this->model_catalog_product->getProduct($product_id);
        endif;
        
        if ($product_info) {
            if (isset($this->request->post['quantity'])) {
                $quantity = $this->request->post['quantity'];
            } else {
                $quantity = 1;
            }
            
            if (isset($this->request->post['event_id'])):
                $json['redirect'] = $this->url->link('catalog/product', 'product_id=' . $product_id);
            endif;
            
            if (isset($this->request->post['option'])) {
                $option = array_filter($this->request->post['option']);
            } else {
                $option = array();
            }
            
            $product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
            
            foreach ($product_options as $product_option) {
                if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                    $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('lang_error_required'), $product_option['name']);
                }
            }
            
            if (isset($this->request->post['recurring_id'])) {
                $recurring_id = $this->request->post['recurring_id'];
            } else {
                $recurring_id = 0;
            }
            
            $recurrings = $this->model_catalog_product->getAllRecurring($product_info['product_id']);
            
            if ($recurrings) {
                $recurring_ids = array();
                
                foreach ($recurrings as $recurring) {
                    $recurring_ids[] = $recurring['recurring_id'];
                }
                
                if (!in_array($recurring_id, $recurring_ids)) {
                    $json['error']['recurring'] = $this->language->get('lang_error_recurring_required');
                }
            }
            
            if (!$json) {
                $this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);
                
                $json['success'] = sprintf($this->language->get('lang_text_success'), $this->url->link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));
                
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
                
                // Totals
                $this->theme->model('setting/module');
                
                $total_data = array();
                $total = 0;
                $taxes = $this->cart->getTaxes();
                
                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $sort_order = array();
                    
                    $results = $this->model_setting_module->getModules('total');
                    
                    foreach ($results as $key => $value) {
                        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                    }
                    
                    array_multisort($sort_order, SORT_ASC, $results);
                    
                    foreach ($results as $result) {
                        if ($this->config->get($result['code'] . '_status')) {
                            $this->theme->model('total/' . $result['code']);
                            
                            $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                        }
                        
                        $sort_order = array();
                        
                        foreach ($total_data as $key => $value) {
                            $sort_order[$key] = $value['sort_order'];
                        }
                        
                        array_multisort($sort_order, SORT_ASC, $total_data);
                    }
                }
                
                $json['total'] = sprintf($this->language->get('lang_text_items'), $this->cart->countProducts() + (isset($this->session->data['gift_cards']) ? count($this->session->data['gift_cards']) : 0), $this->currency->format($total));
            } else {
                $json['redirect'] = str_replace('&amp;', '&', $this->url->link('catalog/product', 'product_id=' . $this->request->post['product_id']));
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function remove() {
        $this->theme->language('checkout/cart');
        
        $json = array();
        
        // Remove
        if (isset($this->request->post['remove'])) {
            $this->cart->remove($this->request->post['remove']);
            
            unset($this->session->data['gift_cards'][$this->request->post['remove']]);
            
            $this->session->data['success'] = $this->language->get('lang_text_remove');
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['reward']);
            
            // Totals
            $this->theme->model('setting/module');
            
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();
            
            // Display prices
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $sort_order = array();
                
                $results = $this->model_setting_module->getModules('total');
                
                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                }
                
                array_multisort($sort_order, SORT_ASC, $results);
                
                foreach ($results as $result) {
                    if ($this->config->get($result['code'] . '_status')) {
                        $this->theme->model('total/' . $result['code']);
                        
                        $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                    }
                }
                
                $sort_order = array();
                
                foreach ($total_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }
                
                array_multisort($sort_order, SORT_ASC, $total_data);
            }
            
            $json['total'] = sprintf($this->language->get('lang_text_items'), $this->cart->countProducts() + (isset($this->session->data['gift_cards']) ? count($this->session->data['gift_cards']) : 0), $this->currency->format($total));
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function quote() {
        $this->theme->language('checkout/cart');
        
        $json = array();
        
        if (!$this->cart->hasProducts()) {
            $json['error']['warning'] = $this->language->get('lang_error_product');
        }
        
        if (!$this->cart->hasShipping()) {
            $json['error']['warning'] = sprintf($this->language->get('lang_error_no_shipping'), $this->url->link('content/contact'));
        }
        
        if ($this->request->post['country_id'] == '') {
            $json['error']['country'] = $this->language->get('lang_error_country');
        }
        
        if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
            $json['error']['zone'] = $this->language->get('lang_error_zone');
        }
        
        $this->theme->model('localization/country');
        
        $country_info = $this->model_localization_country->getCountry($this->request->post['country_id']);
        
        if ($country_info && $country_info['postcode_required'] && ($this->encode->strlen($this->request->post['postcode']) < 2) || ($this->encode->strlen($this->request->post['postcode']) > 10)) {
            $json['error']['postcode'] = $this->language->get('lang_error_postcode');
        }
        
        if (!$json) {
            $this->tax->setShippingAddress($this->request->post['country_id'], $this->request->post['zone_id']);
            
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
            
            $this->theme->model('localization/zone');
            
            $zone_info = $this->model_localization_zone->getZone($this->request->post['zone_id']);
            
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
            
            $this->theme->model('setting/module');
            
            $results = $this->model_setting_module->getModules('shipping');
            
            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->theme->model('shipping/' . $result['code']);
                    
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
                $json['error']['warning'] = sprintf($this->language->get('lang_error_no_shipping'), $this->url->link('content/contact'));
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function country() {
        $json = array();
        
        $this->theme->model('localization/country');
        
        $country_info = $this->model_localization_country->getCountry($this->request->get['country_id']);
        
        if ($country_info) {
            $this->theme->model('localization/zone');
            
            $json = array(
                'country_id'        => $country_info['country_id'], 
                'name'              => $country_info['name'], 
                'iso_code_2'        => $country_info['iso_code_2'], 
                'iso_code_3'        => $country_info['iso_code_3'], 
                'address_format'    => $country_info['address_format'], 
                'postcode_required' => $country_info['postcode_required'], 
                'zone'              => $this->model_localization_zone->getZonesByCountryId($this->request->get['country_id']), 
                'status'            => $country_info['status']
            );
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
