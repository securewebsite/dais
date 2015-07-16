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

class GuestShipping extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
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
            $data['country_id'] = Config::get('config_country_id');
        }
        
        if (isset($this->session->data['guest']['shipping']['zone_id'])) {
            $data['zone_id'] = $this->session->data['guest']['shipping']['zone_id'];
        } elseif (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        Theme::loadjs('javascript/checkout/guest_shipping', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::render('checkout/guest_shipping', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if (Customer::isLogged()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!Cart::hasProducts() && empty($this->session->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $json['redirect'] = Url::link('checkout/cart');
        }
        
        // Check if guest checkout is avaliable.
        if (!Config::get('config_guest_checkout') || Config::get('config_customer_price') || Cart::hasDownload()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        if (!$json) {
            if ((Encode::strlen($this->request->post['firstname']) < 1) || (Encode::strlen($this->request->post['firstname']) > 32)) {
                $json['error']['firstname'] = Lang::get('lang_error_firstname');
            }
            
            if ((Encode::strlen($this->request->post['lastname']) < 1) || (Encode::strlen($this->request->post['lastname']) > 32)) {
                $json['error']['lastname'] = Lang::get('lang_error_lastname');
            }
            
            if ((Encode::strlen($this->request->post['address_1']) < 3) || (Encode::strlen($this->request->post['address_1']) > 128)) {
                $json['error']['address_1'] = Lang::get('lang_error_address_1');
            }
            
            if ((Encode::strlen($this->request->post['city']) < 2) || (Encode::strlen($this->request->post['city']) > 128)) {
                $json['error']['city'] = Lang::get('lang_error_city');
            }
            
            Theme::model('locale/country');
            
            $country_info = LocaleCountry::getCountry($this->request->post['country_id']);
            
            if ($country_info && $country_info['postcode_required'] && (Encode::strlen($this->request->post['postcode']) < 2) || (Encode::strlen($this->request->post['postcode']) > 10)) {
                $json['error']['postcode'] = Lang::get('lang_error_postcode');
            }
            
            if ($this->request->post['country_id'] == '') {
                $json['error']['country'] = Lang::get('lang_error_country');
            }
            
            if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                $json['error']['zone'] = Lang::get('lang_error_zone');
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
            
            Theme::model('locale/country');
            
            $country_info = LocaleCountry::getCountry($this->request->post['country_id']);
            
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
            
            Theme::model('locale/zone');
            
            $zone_info = LocaleZone::getZone($this->request->post['zone_id']);
            
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
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
