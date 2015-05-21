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

class Register extends Controller {
    public function index() {
        $data = $this->theme->language('checkout/checkout');
        
        $data['entry_newsletter'] = sprintf($this->language->get('lang_entry_newsletter'), $this->config->get('config_name'));
        
        $data['customer_groups'] = array();
        
        if (is_array($this->config->get('config_customer_group_display'))) {
            $this->theme->model('account/customer_group');
            
            $customer_groups = $this->model_account_customer_group->getCustomerGroups();
            
            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                    $data['customer_groups'][] = $customer_group;
                }
            }
        }
        
        $data['customer_group_id'] = $this->config->get('config_customer_group_id');
        
        if (isset($this->session->data['shipping_postcode'])) {
            $data['postcode'] = $this->session->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset($this->session->data['shipping_country_id'])) {
            $data['country_id'] = $this->session->data['shipping_country_id'];
        } else {
            $data['country_id'] = $this->config->get('config_country_id');
        }
        
        if (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . $this->language->get('lang_text_select') . '","none":"' . $this->language->get('lang_text_none') . '"}');
        
        $this->theme->model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries();
        
        if ($this->config->get('config_account_id')) {
            $this->theme->model('content/page');
            
            $page_info = $this->model_content_page->getPage($this->config->get('config_account_id'));
            
            if ($page_info) {
                $data['text_agree'] = sprintf($this->language->get('lang_text_agree'), $this->url->link('content/page/info', 'page_id=' . $this->config->get('config_account_id'), 'SSL'), $page_info['title'], $page_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }
        
        $data['shipping_required'] = $this->cart->hasShipping();
        
        $this->theme->loadjs('javascript/checkout/register', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        $this->response->setOutput($this->theme->view('checkout/register', $data));
    }
    
    public function validate() {
        $this->theme->language('checkout/checkout');
        $this->theme->model('account/customer');
        
        $json = array();
        
        // Validate if customer is already logged out.
        if ($this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }
        
        // Validate minimum quantity requirments.
        $products = $this->cart->getProducts();
        
        foreach ($products as $product) {
            $product_total = 0;
            
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total+= $product_2['quantity'];
                }
            }
            
            if ($product['minimum'] > $product_total) {
                $json['redirect'] = $this->url->link('checkout/cart');
                
                break;
            }
        }
        
        if (!$json) {
            if (($this->encode->strlen($this->request->post['username']) < 3) || ($this->encode->strlen($this->request->post['username']) > 16)) {
                $json['error']['username'] = $this->language->get('lang_error_username');
            }
            
            if (($this->encode->strlen($this->request->post['firstname']) < 1) || ($this->encode->strlen($this->request->post['firstname']) > 32)) {
                $json['error']['firstname'] = $this->language->get('lang_error_firstname');
            }
            
            if (($this->encode->strlen($this->request->post['lastname']) < 1) || ($this->encode->strlen($this->request->post['lastname']) > 32)) {
                $json['error']['lastname'] = $this->language->get('lang_error_lastname');
            }
            
            if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
                $json['error']['email'] = $this->language->get('lang_error_email');
            }
            
            if ($this->model_account_customer->getTotalCustomersByUsername($this->request->post['username'])) {
                $json['error']['warning'] = $this->language->get('lang_error_uexists');
            }
            
            if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
                $json['error']['warning'] = $this->language->get('lang_error_exists');
            }
            
            if (($this->encode->strlen($this->request->post['telephone']) < 3) || ($this->encode->strlen($this->request->post['telephone']) > 32)) {
                $json['error']['telephone'] = $this->language->get('lang_error_telephone');
            }
            
            // Customer Group
            $this->theme->model('account/customer_group');
            
            if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                $customer_group_id = $this->request->post['customer_group_id'];
            } else {
                $customer_group_id = $this->config->get('config_customer_group_id');
            }
            
            $customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
            
            if ($customer_group) {
                
                // Company ID
                if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
                    $json['error']['company_id'] = $this->language->get('lang_error_company_id');
                }
                
                // Tax ID
                if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
                    $json['error']['tax_id'] = $this->language->get('lang_error_tax_id');
                }
            }
            
            if (($this->encode->strlen($this->request->post['address_1']) < 3) || ($this->encode->strlen($this->request->post['address_1']) > 128)) {
                $json['error']['address_1'] = $this->language->get('lang_error_address_1');
            }
            
            if (($this->encode->strlen($this->request->post['city']) < 2) || ($this->encode->strlen($this->request->post['city']) > 128)) {
                $json['error']['city'] = $this->language->get('lang_error_city');
            }
            
            $this->theme->model('localization/country');
            
            $country_info = $this->model_localization_country->getCountry($this->request->post['country_id']);
            
            if ($country_info) {
                if ($country_info['postcode_required'] && ($this->encode->strlen($this->request->post['postcode']) < 2) || ($this->encode->strlen($this->request->post['postcode']) > 10)) {
                    $json['error']['postcode'] = $this->language->get('lang_error_postcode');
                }
                
                if ($this->config->get('config_vat') && $this->request->post['tax_id'] && ($this->vat->validate($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
                    $json['error']['tax_id'] = $this->language->get('lang_error_vat');
                }
            }
            
            if ($this->request->post['country_id'] == '') {
                $json['error']['country'] = $this->language->get('lang_error_country');
            }
            
            if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                $json['error']['zone'] = $this->language->get('lang_error_zone');
            }
            
            if (($this->encode->strlen($this->request->post['password']) < 4) || ($this->encode->strlen($this->request->post['password']) > 20)) {
                $json['error']['password'] = $this->language->get('lang_error_password');
            }
            
            if ($this->request->post['confirm'] != $this->request->post['password']) {
                $json['error']['confirm'] = $this->language->get('lang_error_confirm');
            }
            
            if ($this->config->get('config_account_id')) {
                $this->theme->model('content/page');
                
                $page_info = $this->model_content_page->getPage($this->config->get('config_account_id'));
                
                if ($page_info && !isset($this->request->post['agree'])) {
                    $json['error']['warning'] = sprintf($this->language->get('lang_error_agree'), $page_info['title']);
                }
            }
        }
        
        if (!$json) {
            $this->model_account_customer->addCustomer($this->request->post);
            
            $this->session->data['account'] = 'register';
            
            if ($customer_group && !$customer_group['approval']) {
                $this->customer->login($this->request->post['email'], $this->request->post['password']);
                
                $this->session->data['payment_address_id'] = $this->customer->getAddressId();
                $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                $this->session->data['payment_zone_id']    = $this->request->post['zone_id'];
                
                if (!empty($this->request->post['shipping_address'])) {
                    $this->session->data['shipping_address_id'] = $this->customer->getAddressId();
                    $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                    $this->session->data['shipping_zone_id']    = $this->request->post['zone_id'];
                    $this->session->data['shipping_postcode']   = $this->request->post['postcode'];
                }
            } else {
                $json['redirect'] = $this->url->link('account/success');
            }
            
            unset($this->session->data['guest']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
