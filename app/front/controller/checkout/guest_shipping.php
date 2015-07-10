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

class GuestShipping extends Controller {
    public function index() {
        $data = $this->theme->language('checkout/checkout');
        
        if (isset($this->session->data['guest']['shipping']['firstname'])) {
            $data['firstname'] = $this->session->data['guest']['shipping']['firstname'];
        } else {
            $data['firstname'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['lastname'])) {
            $data['lastname'] = $this->session->data['guest']['shipping']['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['company'])) {
            $data['company'] = $this->session->data['guest']['shipping']['company'];
        } else {
            $data['company'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['address_1'])) {
            $data['address_1'] = $this->session->data['guest']['shipping']['address_1'];
        } else {
            $data['address_1'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['address_2'])) {
            $data['address_2'] = $this->session->data['guest']['shipping']['address_2'];
        } else {
            $data['address_2'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['postcode'])) {
            $data['postcode'] = $this->session->data['guest']['shipping']['postcode'];
        } elseif (isset($this->session->data['shipping_postcode'])) {
            $data['postcode'] = $this->session->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['city'])) {
            $data['city'] = $this->session->data['guest']['shipping']['city'];
        } else {
            $data['city'] = '';
        }
        
        if (isset($this->session->data['guest']['shipping']['country_id'])) {
            $data['country_id'] = $this->session->data['guest']['shipping']['country_id'];
        } elseif (isset($this->session->data['shipping_country_id'])) {
            $data['country_id'] = $this->session->data['shipping_country_id'];
        } else {
            $data['country_id'] = $this->config->get('config_country_id');
        }
        
        if (isset($this->session->data['guest']['shipping']['zone_id'])) {
            $data['zone_id'] = $this->session->data['guest']['shipping']['zone_id'];
        } elseif (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . $this->language->get('lang_text_select') . '","none":"' . $this->language->get('lang_text_none') . '"}');
        
        $this->theme->model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries();
        
        $this->theme->loadjs('javascript/checkout/guest_shipping', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        $this->response->setOutput($this->theme->view('checkout/guest_shipping', $data));
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
            
            if (($this->encode->strlen($this->request->post['address_1']) < 3) || ($this->encode->strlen($this->request->post['address_1']) > 128)) {
                $json['error']['address_1'] = $this->language->get('lang_error_address_1');
            }
            
            if (($this->encode->strlen($this->request->post['city']) < 2) || ($this->encode->strlen($this->request->post['city']) > 128)) {
                $json['error']['city'] = $this->language->get('lang_error_city');
            }
            
            $this->theme->model('localization/country');
            
            $country_info = $this->model_localization_country->getCountry($this->request->post['country_id']);
            
            if ($country_info && $country_info['postcode_required'] && ($this->encode->strlen($this->request->post['postcode']) < 2) || ($this->encode->strlen($this->request->post['postcode']) > 10)) {
                $json['error']['postcode'] = $this->language->get('lang_error_postcode');
            }
            
            if ($this->request->post['country_id'] == '') {
                $json['error']['country'] = $this->language->get('lang_error_country');
            }
            
            if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                $json['error']['zone'] = $this->language->get('lang_error_zone');
            }
        }
        
        if (!$json) {
            $this->session->data['guest']['shipping']['firstname'] = trim($this->request->post['firstname']);
            $this->session->data['guest']['shipping']['lastname'] = trim($this->request->post['lastname']);
            $this->session->data['guest']['shipping']['company'] = trim($this->request->post['company']);
            $this->session->data['guest']['shipping']['address_1'] = $this->request->post['address_1'];
            $this->session->data['guest']['shipping']['address_2'] = $this->request->post['address_2'];
            $this->session->data['guest']['shipping']['postcode'] = $this->request->post['postcode'];
            $this->session->data['guest']['shipping']['city'] = $this->request->post['city'];
            $this->session->data['guest']['shipping']['country_id'] = $this->request->post['country_id'];
            $this->session->data['guest']['shipping']['zone_id'] = $this->request->post['zone_id'];
            
            $this->theme->model('localization/country');
            
            $country_info = $this->model_localization_country->getCountry($this->request->post['country_id']);
            
            if ($country_info) {
                $this->session->data['guest']['shipping']['country'] = $country_info['name'];
                $this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
            } else {
                $this->session->data['guest']['shipping']['country'] = '';
                $this->session->data['guest']['shipping']['iso_code_2'] = '';
                $this->session->data['guest']['shipping']['iso_code_3'] = '';
                $this->session->data['guest']['shipping']['address_format'] = '';
            }
            
            $this->theme->model('localization/zone');
            
            $zone_info = $this->model_localization_zone->getZone($this->request->post['zone_id']);
            
            if ($zone_info) {
                $this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
                $this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
            } else {
                $this->session->data['guest']['shipping']['zone'] = '';
                $this->session->data['guest']['shipping']['zone_code'] = '';
            }
            
            $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
            $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
            $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
