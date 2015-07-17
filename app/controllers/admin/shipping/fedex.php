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

namespace App\Controllers\Admin\Shipping;

use App\Controllers\Controller;

class Fedex extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/fedex');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('fedex', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['key'])) {
            $data['error_key'] = $this->error['key'];
        } else {
            $data['error_key'] = '';
        }
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['account'])) {
            $data['error_account'] = $this->error['account'];
        } else {
            $data['error_account'] = '';
        }
        
        if (isset($this->error['meter'])) {
            $data['error_meter'] = $this->error['meter'];
        } else {
            $data['error_meter'] = '';
        }
        
        if (isset($this->error['postcode'])) {
            $data['error_postcode'] = $this->error['postcode'];
        } else {
            $data['error_postcode'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/fedex');
        
        $data['action'] = Url::link('shipping/fedex', '', 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', '', 'SSL');
        
        if (isset(Request::p()->post['fedex_key'])) {
            $data['fedex_key'] = Request::p()->post['fedex_key'];
        } else {
            $data['fedex_key'] = Config::get('fedex_key');
        }
        
        if (isset(Request::p()->post['fedex_password'])) {
            $data['fedex_password'] = Request::p()->post['fedex_password'];
        } else {
            $data['fedex_password'] = Config::get('fedex_password');
        }
        
        if (isset(Request::p()->post['fedex_account'])) {
            $data['fedex_account'] = Request::p()->post['fedex_account'];
        } else {
            $data['fedex_account'] = Config::get('fedex_account');
        }
        
        if (isset(Request::p()->post['fedex_meter'])) {
            $data['fedex_meter'] = Request::p()->post['fedex_meter'];
        } else {
            $data['fedex_meter'] = Config::get('fedex_meter');
        }
        
        if (isset(Request::p()->post['fedex_postcode'])) {
            $data['fedex_postcode'] = Request::p()->post['fedex_postcode'];
        } else {
            $data['fedex_postcode'] = Config::get('fedex_postcode');
        }
        
        if (isset(Request::p()->post['fedex_test'])) {
            $data['fedex_test'] = Request::p()->post['fedex_test'];
        } else {
            $data['fedex_test'] = Config::get('fedex_test');
        }
        
        if (isset(Request::p()->post['fedex_service'])) {
            $data['fedex_service'] = Request::p()->post['fedex_service'];
        } elseif ($this->config->has('fedex_service')) {
            $data['fedex_service'] = Config::get('fedex_service');
        } else {
            $data['fedex_service'] = array();
        }
        
        $data['services'] = array();
        
        $data['services'][] = array('text' => Lang::get('lang_text_europe_first_international_priority'), 'value' => 'EUROPE_FIRST_INTERNATIONAL_PRIORITY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_1_day_freight'), 'value' => 'FEDEX_1_DAY_FREIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_2_day'), 'value' => 'FEDEX_2_DAY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_2_day_am'), 'value' => 'FEDEX_2_DAY_AM');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_2_day_freight'), 'value' => 'FEDEX_2_DAY_FREIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_3_day_freight'), 'value' => 'FEDEX_3_DAY_FREIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_express_saver'), 'value' => 'FEDEX_EXPRESS_SAVER');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_first_freight'), 'value' => 'FEDEX_FIRST_FREIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_freight_economy'), 'value' => 'FEDEX_FREIGHT_ECONOMY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_freight_priority'), 'value' => 'FEDEX_FREIGHT_PRIORITY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_fedex_ground'), 'value' => 'FEDEX_GROUND');
        
        $data['services'][] = array('text' => Lang::get('lang_text_first_overnight'), 'value' => 'FIRST_OVERNIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_ground_home_delivery'), 'value' => 'GROUND_HOME_DELIVERY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_international_economy'), 'value' => 'INTERNATIONAL_ECONOMY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_international_economy_freight'), 'value' => 'INTERNATIONAL_ECONOMY_FREIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_international_first'), 'value' => 'INTERNATIONAL_FIRST');
        
        $data['services'][] = array('text' => Lang::get('lang_text_international_priority'), 'value' => 'INTERNATIONAL_PRIORITY');
        
        $data['services'][] = array('text' => Lang::get('lang_text_international_priority_freight'), 'value' => 'INTERNATIONAL_PRIORITY_FREIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_priority_overnight'), 'value' => 'PRIORITY_OVERNIGHT');
        
        $data['services'][] = array('text' => Lang::get('lang_text_smart_post'), 'value' => 'SMART_POST');
        
        $data['services'][] = array('text' => Lang::get('lang_text_standard_overnight'), 'value' => 'STANDARD_OVERNIGHT');
        
        if (isset(Request::p()->post['fedex_dropoff_type'])) {
            $data['fedex_dropoff_type'] = Request::p()->post['fedex_dropoff_type'];
        } else {
            $data['fedex_dropoff_type'] = Config::get('fedex_dropoff_type');
        }
        
        if (isset(Request::p()->post['fedex_packaging_type'])) {
            $data['fedex_packaging_type'] = Request::p()->post['fedex_packaging_type'];
        } else {
            $data['fedex_packaging_type'] = Config::get('fedex_packaging_type');
        }
        
        if (isset(Request::p()->post['fedex_rate_type'])) {
            $data['fedex_rate_type'] = Request::p()->post['fedex_rate_type'];
        } else {
            $data['fedex_rate_type'] = Config::get('fedex_rate_type');
        }
        
        if (isset(Request::p()->post['fedex_destination_type'])) {
            $data['fedex_destination_type'] = Request::p()->post['fedex_destination_type'];
        } else {
            $data['fedex_destination_type'] = Config::get('fedex_destination_type');
        }
        
        if (isset(Request::p()->post['fedex_display_time'])) {
            $data['fedex_display_time'] = Request::p()->post['fedex_display_time'];
        } else {
            $data['fedex_display_time'] = Config::get('fedex_display_time');
        }
        
        if (isset(Request::p()->post['fedex_display_weight'])) {
            $data['fedex_display_weight'] = Request::p()->post['fedex_display_weight'];
        } else {
            $data['fedex_display_weight'] = Config::get('fedex_display_weight');
        }
        
        if (isset(Request::p()->post['fedex_weight_class_id'])) {
            $data['fedex_weight_class_id'] = Request::p()->post['fedex_weight_class_id'];
        } else {
            $data['fedex_weight_class_id'] = Config::get('fedex_weight_class_id');
        }
        
        Theme::model('locale/weight_class');
        
        $data['weight_classes'] = LocaleWeightClass::getWeightClasses();
        
        if (isset(Request::p()->post['fedex_tax_class_id'])) {
            $data['fedex_tax_class_id'] = Request::p()->post['fedex_tax_class_id'];
        } else {
            $data['fedex_tax_class_id'] = Config::get('fedex_tax_class_id');
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = LocaleTaxClass::getTaxClasses();
        
        if (isset(Request::p()->post['fedex_geo_zone_id'])) {
            $data['fedex_geo_zone_id'] = Request::p()->post['fedex_geo_zone_id'];
        } else {
            $data['fedex_geo_zone_id'] = Config::get('fedex_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['fedex_status'])) {
            $data['fedex_status'] = Request::p()->post['fedex_status'];
        } else {
            $data['fedex_status'] = Config::get('fedex_status');
        }
        
        if (isset(Request::p()->post['fedex_sort_order'])) {
            $data['fedex_sort_order'] = Request::p()->post['fedex_sort_order'];
        } else {
            $data['fedex_sort_order'] = Config::get('fedex_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('shipping/fedex', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/fedex')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['fedex_key']) {
            $this->error['key'] = Lang::get('lang_error_key');
        }
        
        if (!Request::p()->post['fedex_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!Request::p()->post['fedex_account']) {
            $this->error['account'] = Lang::get('lang_error_account');
        }
        
        if (!Request::p()->post['fedex_meter']) {
            $this->error['meter'] = Lang::get('lang_error_meter');
        }
        
        if (!Request::p()->post['fedex_postcode']) {
            $this->error['postcode'] = Lang::get('lang_error_postcode');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
