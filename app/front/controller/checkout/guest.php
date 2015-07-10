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

class Guest extends Controller {
    public function index() {
        $data = $this->theme->language('checkout/checkout');
        
        if (isset($this->session->data['guest']['firstname'])) {
            $data['firstname'] = $this->session->data['guest']['firstname'];
        } else {
            $data['firstname'] = '';
        }
        
        if (isset($this->session->data['guest']['lastname'])) {
            $data['lastname'] = $this->session->data['guest']['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset($this->session->data['guest']['email'])) {
            $data['email'] = $this->session->data['guest']['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset($this->session->data['guest']['telephone'])) {
            $data['telephone'] = $this->session->data['guest']['telephone'];
        } else {
            $data['telephone'] = '';
        }
        
        if (isset($this->session->data['guest']['payment']['company'])) {
            $data['company'] = $this->session->data['guest']['payment']['company'];
        } else {
            $data['company'] = '';
        }
        
        $this->theme->model('account/customer_group');
        
        $data['customer_groups'] = array();
        
        if (is_array($this->config->get('config_customer_group_display'))) {
            $customer_groups = $this->model_account_customer_group->getCustomerGroups();
            
            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                    $data['customer_groups'][] = $customer_group;
                }
            }
        }
        
        if (isset($this->session->data['guest']['customer_group_id'])) {
            $data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
        } else {
            $data['customer_group_id'] = $this->config->get('config_default_visibility');
        }
        
        // Company ID
        if (isset($this->session->data['guest']['payment']['company_id'])) {
            $data['company_id'] = $this->session->data['guest']['payment']['company_id'];
        } else {
            $data['company_id'] = '';
        }
        
        // Tax ID
        if (isset($this->session->data['guest']['payment']['tax_id'])) {
            $data['tax_id'] = $this->session->data['guest']['payment']['tax_id'];
        } else {
            $data['tax_id'] = '';
        }
        
        if (isset($this->session->data['guest']['payment']['address_1'])) {
            $data['address_1'] = $this->session->data['guest']['payment']['address_1'];
        } else {
            $data['address_1'] = '';
        }
        
        if (isset($this->session->data['guest']['payment']['address_2'])) {
            $data['address_2'] = $this->session->data['guest']['payment']['address_2'];
        } else {
            $data['address_2'] = '';
        }
        
        if (isset($this->session->data['guest']['payment']['postcode'])) {
            $data['postcode'] = $this->session->data['guest']['payment']['postcode'];
        } elseif (isset($this->session->data['shipping_postcode'])) {
            $data['postcode'] = $this->session->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset($this->session->data['guest']['payment']['city'])) {
            $data['city'] = $this->session->data['guest']['payment']['city'];
        } else {
            $data['city'] = '';
        }
        
        if (isset($this->session->data['guest']['payment']['country_id'])) {
            $data['country_id'] = $this->session->data['guest']['payment']['country_id'];
        } elseif (isset($this->session->data['shipping_country_id'])) {
            $data['country_id'] = $this->session->data['shipping_country_id'];
        } else {
            $data['country_id'] = $this->config->get('config_country_id');
        }
        
        if (isset($this->session->data['guest']['payment']['zone_id'])) {
            $data['zone_id'] = $this->session->data['guest']['payment']['zone_id'];
        } elseif (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . $this->language->get('lang_text_select') . '","none":"' . $this->language->get('lang_text_none') . '"}');
        
        $this->theme->model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries();
        
        $data['shipping_required'] = $this->cart->hasShipping();
        
        if (isset($this->session->data['guest']['shipping_address'])) {
            $data['shipping_address'] = $this->session->data['guest']['shipping_address'];
        } else {
            $data['shipping_address'] = true;
        }
        
        $this->theme->loadjs('javascript/checkout/guest', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        $this->response->setOutput($this->theme->view('checkout/guest', $data));
    }
    
    public function validate() {
        $this->theme->language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if ($this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }
        
        // Check if guest checkout is avaliable.
        if (!$this->config->get('config_guest_checkout') || $this->config->get('config_customer_price') || $this->cart->hasDownload()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        if (!$json) {
            if (($this->encode->strlen($this->request->post['firstname']) < 1) || ($this->encode->strlen($this->request->post['firstname']) > 32)) {
                $json['error']['firstname'] = $this->language->get('lang_error_firstname');
            }
            
            if (($this->encode->strlen($this->request->post['lastname']) < 1) || ($this->encode->strlen($this->request->post['lastname']) > 32)) {
                $json['error']['lastname'] = $this->language->get('lang_error_lastname');
            }
            
            if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
                $json['error']['email'] = $this->language->get('lang_error_email');
            }
            
            if (($this->encode->strlen($this->request->post['telephone']) < 3) || ($this->encode->strlen($this->request->post['telephone']) > 32)) {
                $json['error']['telephone'] = $this->language->get('lang_error_telephone');
            }
            
            // Customer Group
            $this->theme->model('account/customer_group');
            
            if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                $customer_group_id = ($this->request->post['customer_group_id'] == $this->config->get('config_default_visibility')) ? $this->request->post['customer_group_id'] : $this->config->get('config_default_visibility');
            } else {
                $customer_group_id = $this->config->get('config_default_visibility');
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
        }
        
        if (!$json) {
            $this->session->data['guest']['customer_group_id'] = $customer_group_id;
            $this->session->data['guest']['firstname']         = $this->request->post['firstname'];
            $this->session->data['guest']['lastname']          = $this->request->post['lastname'];
            $this->session->data['guest']['email']             = $this->request->post['email'];
            $this->session->data['guest']['telephone']         = $this->request->post['telephone'];
            
            $this->session->data['guest']['payment']['firstname']  = $this->request->post['firstname'];
            $this->session->data['guest']['payment']['lastname']   = $this->request->post['lastname'];
            $this->session->data['guest']['payment']['company']    = $this->request->post['company'];
            $this->session->data['guest']['payment']['company_id'] = $this->request->post['company_id'];
            $this->session->data['guest']['payment']['tax_id']     = $this->request->post['tax_id'];
            $this->session->data['guest']['payment']['address_1']  = $this->request->post['address_1'];
            $this->session->data['guest']['payment']['address_2']  = $this->request->post['address_2'];
            $this->session->data['guest']['payment']['postcode']   = $this->request->post['postcode'];
            $this->session->data['guest']['payment']['city']       = $this->request->post['city'];
            $this->session->data['guest']['payment']['country_id'] = $this->request->post['country_id'];
            $this->session->data['guest']['payment']['zone_id']    = $this->request->post['zone_id'];
            
            $this->theme->model('localization/country');
            
            $country_info = $this->model_localization_country->getCountry($this->request->post['country_id']);
            
            if ($country_info) {
                $this->session->data['guest']['payment']['country']        = $country_info['name'];
                $this->session->data['guest']['payment']['iso_code_2']     = $country_info['iso_code_2'];
                $this->session->data['guest']['payment']['iso_code_3']     = $country_info['iso_code_3'];
                $this->session->data['guest']['payment']['address_format'] = $country_info['address_format'];
            } else {
                $this->session->data['guest']['payment']['country']        = '';
                $this->session->data['guest']['payment']['iso_code_2']     = '';
                $this->session->data['guest']['payment']['iso_code_3']     = '';
                $this->session->data['guest']['payment']['address_format'] = '';
            }
            
            $this->theme->model('localization/zone');
            
            $zone_info = $this->model_localization_zone->getZone($this->request->post['zone_id']);
            
            if ($zone_info) {
                $this->session->data['guest']['payment']['zone']      = $zone_info['name'];
                $this->session->data['guest']['payment']['zone_code'] = $zone_info['code'];
            } else {
                $this->session->data['guest']['payment']['zone']      = '';
                $this->session->data['guest']['payment']['zone_code'] = '';
            }
            
            if (!empty($this->request->post['shipping_address'])) {
                $this->session->data['guest']['shipping_address'] = true;
            } else {
                $this->session->data['guest']['shipping_address'] = false;
            }
            
            // Default Payment Address
            $this->session->data['payment_country_id'] = $this->request->post['country_id'];
            $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
            
            if ($this->session->data['guest']['shipping_address']) {
                $this->session->data['guest']['shipping']['firstname']  = $this->request->post['firstname'];
                $this->session->data['guest']['shipping']['lastname']   = $this->request->post['lastname'];
                $this->session->data['guest']['shipping']['company']    = $this->request->post['company'];
                $this->session->data['guest']['shipping']['address_1']  = $this->request->post['address_1'];
                $this->session->data['guest']['shipping']['address_2']  = $this->request->post['address_2'];
                $this->session->data['guest']['shipping']['postcode']   = $this->request->post['postcode'];
                $this->session->data['guest']['shipping']['city']       = $this->request->post['city'];
                $this->session->data['guest']['shipping']['country_id'] = $this->request->post['country_id'];
                $this->session->data['guest']['shipping']['zone_id']    = $this->request->post['zone_id'];
                
                if ($country_info) {
                    $this->session->data['guest']['shipping']['country']        = $country_info['name'];
                    $this->session->data['guest']['shipping']['iso_code_2']     = $country_info['iso_code_2'];
                    $this->session->data['guest']['shipping']['iso_code_3']     = $country_info['iso_code_3'];
                    $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
                } else {
                    $this->session->data['guest']['shipping']['country']        = '';
                    $this->session->data['guest']['shipping']['iso_code_2']     = '';
                    $this->session->data['guest']['shipping']['iso_code_3']     = '';
                    $this->session->data['guest']['shipping']['address_format'] = '';
                }
                
                if ($zone_info) {
                    $this->session->data['guest']['shipping']['zone']      = $zone_info['name'];
                    $this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
                } else {
                    $this->session->data['guest']['shipping']['zone']      = '';
                    $this->session->data['guest']['shipping']['zone_code'] = '';
                }
                
                // Default Shipping Address
                $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                $this->session->data['shipping_zone_id']    = $this->request->post['zone_id'];
                $this->session->data['shipping_postcode']   = $this->request->post['postcode'];
            }
            
            $this->session->data['account'] = 'guest';
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function zone() {
        $output = '<option value="">' . $this->language->get('lang_text_select') . '</option>';
        
        $this->theme->model('localization/zone');
        
        $results = $this->model_localization_zone->getZonesByCountryId($this->request->get['country_id']);
        
        foreach ($results as $result) {
            $output.= '<option value="' . $result['zone_id'] . '"';
            
            if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
                $output.= ' selected="selected"';
            }
            
            $output.= '>' . $result['name'] . '</option>';
        }
        
        if (!$results) {
            $output.= '<option value="0">' . $this->language->get('lang_text_none') . '</option>';
        }
        
        $this->response->setOutput($output);
    }
}
