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

class Ups extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/ups');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('ups', Request::post());
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
        
        if (isset($this->error['username'])) {
            $data['error_username'] = $this->error['username'];
        } else {
            $data['error_username'] = '';
        }
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['city'])) {
            $data['error_city'] = $this->error['city'];
        } else {
            $data['error_city'] = '';
        }
        
        if (isset($this->error['state'])) {
            $data['error_state'] = $this->error['state'];
        } else {
            $data['error_state'] = '';
        }
        
        if (isset($this->error['country'])) {
            $data['error_country'] = $this->error['country'];
        } else {
            $data['error_country'] = '';
        }
        
        if (isset($this->error['dimension'])) {
            $data['error_dimension'] = $this->error['dimension'];
        } else {
            $data['error_dimension'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/ups');
        
        $data['action'] = Url::link('shipping/ups', '', 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', '', 'SSL');
        
        if (isset(Request::p()->post['ups_key'])) {
            $data['ups_key'] = Request::p()->post['ups_key'];
        } else {
            $data['ups_key'] = Config::get('ups_key');
        }
        
        if (isset(Request::p()->post['ups_username'])) {
            $data['ups_username'] = Request::p()->post['ups_username'];
        } else {
            $data['ups_username'] = Config::get('ups_username');
        }
        
        if (isset(Request::p()->post['ups_password'])) {
            $data['ups_password'] = Request::p()->post['ups_password'];
        } else {
            $data['ups_password'] = Config::get('ups_password');
        }
        
        if (isset(Request::p()->post['ups_pickup'])) {
            $data['ups_pickup'] = Request::p()->post['ups_pickup'];
        } else {
            $data['ups_pickup'] = Config::get('ups_pickup');
        }
        
        $data['pickups'] = array();
        
        $data['pickups'][] = array('value' => '01', 'text' => Lang::get('lang_text_daily_pickup'));
        
        $data['pickups'][] = array('value' => '03', 'text' => Lang::get('lang_text_customer_counter'));
        
        $data['pickups'][] = array('value' => '06', 'text' => Lang::get('lang_text_one_time_pickup'));
        
        $data['pickups'][] = array('value' => '07', 'text' => Lang::get('lang_text_on_call_air_pickup'));
        
        $data['pickups'][] = array('value' => '19', 'text' => Lang::get('lang_text_letter_center'));
        
        $data['pickups'][] = array('value' => '20', 'text' => Lang::get('lang_text_air_service_center'));
        
        $data['pickups'][] = array('value' => '11', 'text' => Lang::get('lang_text_suggested_retail_rates'));
        
        if (isset(Request::p()->post['ups_packaging'])) {
            $data['ups_packaging'] = Request::p()->post['ups_packaging'];
        } else {
            $data['ups_packaging'] = Config::get('ups_packaging');
        }
        
        $data['packages'] = array();
        
        $data['packages'][] = array('value' => '02', 'text' => Lang::get('lang_text_package'));
        
        $data['packages'][] = array('value' => '01', 'text' => Lang::get('lang_text_ups_letter'));
        
        $data['packages'][] = array('value' => '03', 'text' => Lang::get('lang_text_ups_tube'));
        
        $data['packages'][] = array('value' => '04', 'text' => Lang::get('lang_text_ups_pak'));
        
        $data['packages'][] = array('value' => '21', 'text' => Lang::get('lang_text_ups_express_box'));
        
        $data['packages'][] = array('value' => '24', 'text' => Lang::get('lang_text_ups_25kg_box'));
        
        $data['packages'][] = array('value' => '25', 'text' => Lang::get('lang_text_ups_10kg_box'));
        
        if (isset(Request::p()->post['ups_classification'])) {
            $data['ups_classification'] = Request::p()->post['ups_classification'];
        } else {
            $data['ups_classification'] = Config::get('ups_classification');
        }
        
        $data['classifications'][] = array('value' => '01', 'text' => '01');
        
        $data['classifications'][] = array('value' => '03', 'text' => '03');
        
        $data['classifications'][] = array('value' => '04', 'text' => '04');
        
        if (isset(Request::p()->post['ups_origin'])) {
            $data['ups_origin'] = Request::p()->post['ups_origin'];
        } else {
            $data['ups_origin'] = Config::get('ups_origin');
        }
        
        $data['origins'] = array();
        
        $data['origins'][] = array('value' => 'US', 'text' => Lang::get('lang_text_us'));
        
        $data['origins'][] = array('value' => 'CA', 'text' => Lang::get('lang_text_ca'));
        
        $data['origins'][] = array('value' => 'EU', 'text' => Lang::get('lang_text_eu'));
        
        $data['origins'][] = array('value' => 'PR', 'text' => Lang::get('lang_text_pr'));
        
        $data['origins'][] = array('value' => 'MX', 'text' => Lang::get('lang_text_mx'));
        
        $data['origins'][] = array('value' => 'other', 'text' => Lang::get('lang_text_other'));
        
        if (isset(Request::p()->post['ups_city'])) {
            $data['ups_city'] = Request::p()->post['ups_city'];
        } else {
            $data['ups_city'] = Config::get('ups_city');
        }
        
        if (isset(Request::p()->post['ups_state'])) {
            $data['ups_state'] = Request::p()->post['ups_state'];
        } else {
            $data['ups_state'] = Config::get('ups_state');
        }
        
        if (isset(Request::p()->post['ups_country'])) {
            $data['ups_country'] = Request::p()->post['ups_country'];
        } else {
            $data['ups_country'] = Config::get('ups_country');
        }
        
        if (isset(Request::p()->post['ups_postcode'])) {
            $data['ups_postcode'] = Request::p()->post['ups_postcode'];
        } else {
            $data['ups_postcode'] = Config::get('ups_postcode');
        }
        
        if (isset(Request::p()->post['ups_test'])) {
            $data['ups_test'] = Request::p()->post['ups_test'];
        } else {
            $data['ups_test'] = Config::get('ups_test');
        }
        
        if (isset(Request::p()->post['ups_quote_type'])) {
            $data['ups_quote_type'] = Request::p()->post['ups_quote_type'];
        } else {
            $data['ups_quote_type'] = Config::get('ups_quote_type');
        }
        
        $data['quote_types'] = array();
        
        $data['quote_types'][] = array('value' => 'residential', 'text' => Lang::get('lang_text_residential'));
        
        $data['quote_types'][] = array('value' => 'commercial', 'text' => Lang::get('lang_text_commercial'));
        
        // US
        if (isset(Request::p()->post['ups_us_01'])) {
            $data['ups_us_01'] = Request::p()->post['ups_us_01'];
        } else {
            $data['ups_us_01'] = Config::get('ups_us_01');
        }
        
        if (isset(Request::p()->post['ups_us_02'])) {
            $data['ups_us_02'] = Request::p()->post['ups_us_02'];
        } else {
            $data['ups_us_02'] = Config::get('ups_us_02');
        }
        
        if (isset(Request::p()->post['ups_us_03'])) {
            $data['ups_us_03'] = Request::p()->post['ups_us_03'];
        } else {
            $data['ups_us_03'] = Config::get('ups_us_03');
        }
        
        if (isset(Request::p()->post['ups_us_07'])) {
            $data['ups_us_07'] = Request::p()->post['ups_us_07'];
        } else {
            $data['ups_us_07'] = Config::get('ups_us_07');
        }
        
        if (isset(Request::p()->post['ups_us_08'])) {
            $data['ups_us_08'] = Request::p()->post['ups_us_08'];
        } else {
            $data['ups_us_08'] = Config::get('ups_us_08');
        }
        
        if (isset(Request::p()->post['ups_us_11'])) {
            $data['ups_us_11'] = Request::p()->post['ups_us_11'];
        } else {
            $data['ups_us_11'] = Config::get('ups_us_11');
        }
        
        if (isset(Request::p()->post['ups_us_12'])) {
            $data['ups_us_12'] = Request::p()->post['ups_us_12'];
        } else {
            $data['ups_us_12'] = Config::get('ups_us_12');
        }
        
        if (isset(Request::p()->post['ups_us_13'])) {
            $data['ups_us_13'] = Request::p()->post['ups_us_13'];
        } else {
            $data['ups_us_13'] = Config::get('ups_us_13');
        }
        
        if (isset(Request::p()->post['ups_us_14'])) {
            $data['ups_us_14'] = Request::p()->post['ups_us_14'];
        } else {
            $data['ups_us_14'] = Config::get('ups_us_14');
        }
        
        if (isset(Request::p()->post['ups_us_54'])) {
            $data['ups_us_54'] = Request::p()->post['ups_us_54'];
        } else {
            $data['ups_us_54'] = Config::get('ups_us_54');
        }
        
        if (isset(Request::p()->post['ups_us_59'])) {
            $data['ups_us_59'] = Request::p()->post['ups_us_59'];
        } else {
            $data['ups_us_59'] = Config::get('ups_us_59');
        }
        
        if (isset(Request::p()->post['ups_us_65'])) {
            $data['ups_us_65'] = Request::p()->post['ups_us_65'];
        } else {
            $data['ups_us_65'] = Config::get('ups_us_65');
        }
        
        // Puerto Rico
        if (isset(Request::p()->post['ups_pr_01'])) {
            $data['ups_pr_01'] = Request::p()->post['ups_pr_01'];
        } else {
            $data['ups_pr_01'] = Config::get('ups_pr_01');
        }
        
        if (isset(Request::p()->post['ups_pr_02'])) {
            $data['ups_pr_02'] = Request::p()->post['ups_pr_02'];
        } else {
            $data['ups_pr_02'] = Config::get('ups_pr_02');
        }
        
        if (isset(Request::p()->post['ups_pr_03'])) {
            $data['ups_pr_03'] = Request::p()->post['ups_pr_03'];
        } else {
            $data['ups_pr_03'] = Config::get('ups_pr_03');
        }
        
        if (isset(Request::p()->post['ups_pr_07'])) {
            $data['ups_pr_07'] = Request::p()->post['ups_pr_07'];
        } else {
            $data['ups_pr_07'] = Config::get('ups_pr_07');
        }
        
        if (isset(Request::p()->post['ups_pr_08'])) {
            $data['ups_pr_08'] = Request::p()->post['ups_pr_08'];
        } else {
            $data['ups_pr_08'] = Config::get('ups_pr_08');
        }
        
        if (isset(Request::p()->post['ups_pr_14'])) {
            $data['ups_pr_14'] = Request::p()->post['ups_pr_14'];
        } else {
            $data['ups_pr_14'] = Config::get('ups_pr_14');
        }
        
        if (isset(Request::p()->post['ups_pr_54'])) {
            $data['ups_pr_54'] = Request::p()->post['ups_pr_54'];
        } else {
            $data['ups_pr_54'] = Config::get('ups_pr_54');
        }
        
        if (isset(Request::p()->post['ups_pr_65'])) {
            $data['ups_pr_65'] = Request::p()->post['ups_pr_65'];
        } else {
            $data['ups_pr_65'] = Config::get('ups_pr_65');
        }
        
        // Canada
        if (isset(Request::p()->post['ups_ca_01'])) {
            $data['ups_ca_01'] = Request::p()->post['ups_ca_01'];
        } else {
            $data['ups_ca_01'] = Config::get('ups_ca_01');
        }
        
        if (isset(Request::p()->post['ups_ca_02'])) {
            $data['ups_ca_02'] = Request::p()->post['ups_ca_02'];
        } else {
            $data['ups_ca_02'] = Config::get('ups_ca_02');
        }
        
        if (isset(Request::p()->post['ups_ca_07'])) {
            $data['ups_ca_07'] = Request::p()->post['ups_ca_07'];
        } else {
            $data['ups_ca_07'] = Config::get('ups_ca_07');
        }
        
        if (isset(Request::p()->post['ups_ca_08'])) {
            $data['ups_ca_08'] = Request::p()->post['ups_ca_08'];
        } else {
            $data['ups_ca_08'] = Config::get('ups_ca_08');
        }
        
        if (isset(Request::p()->post['ups_ca_11'])) {
            $data['ups_ca_11'] = Request::p()->post['ups_ca_11'];
        } else {
            $data['ups_ca_11'] = Config::get('ups_ca_11');
        }
        
        if (isset(Request::p()->post['ups_ca_12'])) {
            $data['ups_ca_12'] = Request::p()->post['ups_ca_12'];
        } else {
            $data['ups_ca_12'] = Config::get('ups_ca_12');
        }
        
        if (isset(Request::p()->post['ups_ca_13'])) {
            $data['ups_ca_13'] = Request::p()->post['ups_ca_13'];
        } else {
            $data['ups_ca_13'] = Config::get('ups_ca_13');
        }
        
        if (isset(Request::p()->post['ups_ca_14'])) {
            $data['ups_ca_14'] = Request::p()->post['ups_ca_14'];
        } else {
            $data['ups_ca_14'] = Config::get('ups_ca_14');
        }
        
        if (isset(Request::p()->post['ups_ca_54'])) {
            $data['ups_ca_54'] = Request::p()->post['ups_ca_54'];
        } else {
            $data['ups_ca_54'] = Config::get('ups_ca_54');
        }
        
        if (isset(Request::p()->post['ups_ca_65'])) {
            $data['ups_ca_65'] = Request::p()->post['ups_ca_65'];
        } else {
            $data['ups_ca_65'] = Config::get('ups_ca_65');
        }
        
        // Mexico
        if (isset(Request::p()->post['ups_mx_07'])) {
            $data['ups_mx_07'] = Request::p()->post['ups_mx_07'];
        } else {
            $data['ups_mx_07'] = Config::get('ups_mx_07');
        }
        
        if (isset(Request::p()->post['ups_mx_08'])) {
            $data['ups_mx_08'] = Request::p()->post['ups_mx_08'];
        } else {
            $data['ups_mx_08'] = Config::get('ups_mx_08');
        }
        
        if (isset(Request::p()->post['ups_mx_54'])) {
            $data['ups_mx_54'] = Request::p()->post['ups_mx_54'];
        } else {
            $data['ups_mx_54'] = Config::get('ups_mx_54');
        }
        
        if (isset(Request::p()->post['ups_mx_65'])) {
            $data['ups_mx_65'] = Request::p()->post['ups_mx_65'];
        } else {
            $data['ups_mx_65'] = Config::get('ups_mx_65');
        }
        
        // EU
        if (isset(Request::p()->post['ups_eu_07'])) {
            $data['ups_eu_07'] = Request::p()->post['ups_eu_07'];
        } else {
            $data['ups_eu_07'] = Config::get('ups_eu_07');
        }
        
        if (isset(Request::p()->post['ups_eu_08'])) {
            $data['ups_eu_08'] = Request::p()->post['ups_eu_08'];
        } else {
            $data['ups_eu_08'] = Config::get('ups_eu_08');
        }
        
        if (isset(Request::p()->post['ups_eu_11'])) {
            $data['ups_eu_11'] = Request::p()->post['ups_eu_11'];
        } else {
            $data['ups_eu_11'] = Config::get('ups_eu_11');
        }
        
        if (isset(Request::p()->post['ups_eu_54'])) {
            $data['ups_eu_54'] = Request::p()->post['ups_eu_54'];
        } else {
            $data['ups_eu_54'] = Config::get('ups_eu_54');
        }
        
        if (isset(Request::p()->post['ups_eu_65'])) {
            $data['ups_eu_65'] = Request::p()->post['ups_eu_65'];
        } else {
            $data['ups_eu_65'] = Config::get('ups_eu_65');
        }
        
        if (isset(Request::p()->post['ups_eu_82'])) {
            $data['ups_eu_82'] = Request::p()->post['ups_eu_82'];
        } else {
            $data['ups_eu_82'] = Config::get('ups_eu_82');
        }
        
        if (isset(Request::p()->post['ups_eu_83'])) {
            $data['ups_eu_83'] = Request::p()->post['ups_eu_83'];
        } else {
            $data['ups_eu_83'] = Config::get('ups_eu_83');
        }
        
        if (isset(Request::p()->post['ups_eu_84'])) {
            $data['ups_eu_84'] = Request::p()->post['ups_eu_84'];
        } else {
            $data['ups_eu_84'] = Config::get('ups_eu_84');
        }
        
        if (isset(Request::p()->post['ups_eu_85'])) {
            $data['ups_eu_85'] = Request::p()->post['ups_eu_85'];
        } else {
            $data['ups_eu_85'] = Config::get('ups_eu_85');
        }
        
        if (isset(Request::p()->post['ups_eu_86'])) {
            $data['ups_eu_86'] = Request::p()->post['ups_eu_86'];
        } else {
            $data['ups_eu_86'] = Config::get('ups_eu_86');
        }
        
        // Other
        if (isset(Request::p()->post['ups_other_07'])) {
            $data['ups_other_07'] = Request::p()->post['ups_other_07'];
        } else {
            $data['ups_other_07'] = Config::get('ups_other_07');
        }
        
        if (isset(Request::p()->post['ups_other_08'])) {
            $data['ups_other_08'] = Request::p()->post['ups_other_08'];
        } else {
            $data['ups_other_08'] = Config::get('ups_other_08');
        }
        
        if (isset(Request::p()->post['ups_other_11'])) {
            $data['ups_other_11'] = Request::p()->post['ups_other_11'];
        } else {
            $data['ups_other_11'] = Config::get('ups_other_11');
        }
        
        if (isset(Request::p()->post['ups_other_54'])) {
            $data['ups_other_54'] = Request::p()->post['ups_other_54'];
        } else {
            $data['ups_other_54'] = Config::get('ups_other_54');
        }
        
        if (isset(Request::p()->post['ups_other_65'])) {
            $data['ups_other_65'] = Request::p()->post['ups_other_65'];
        } else {
            $data['ups_other_65'] = Config::get('ups_other_65');
        }
        
        if (isset(Request::p()->post['ups_display_weight'])) {
            $data['ups_display_weight'] = Request::p()->post['ups_display_weight'];
        } else {
            $data['ups_display_weight'] = Config::get('ups_display_weight');
        }
        
        if (isset(Request::p()->post['ups_insurance'])) {
            $data['ups_insurance'] = Request::p()->post['ups_insurance'];
        } else {
            $data['ups_insurance'] = Config::get('ups_insurance');
        }
        
        if (isset(Request::p()->post['ups_weight_class_id'])) {
            $data['ups_weight_class_id'] = Request::p()->post['ups_weight_class_id'];
        } else {
            $data['ups_weight_class_id'] = Config::get('ups_weight_class_id');
        }
        
        Theme::model('locale/weight_class');
        
        $data['weight_classes'] = LocaleWeightClass::getWeightClasses();
        
        if (isset(Request::p()->post['ups_length_code'])) {
            $data['ups_length_code'] = Request::p()->post['ups_length_code'];
        } else {
            $data['ups_length_code'] = Config::get('ups_length_code');
        }
        
        if (isset(Request::p()->post['ups_length_class_id'])) {
            $data['ups_length_class_id'] = Request::p()->post['ups_length_class_id'];
        } else {
            $data['ups_length_class_id'] = Config::get('ups_length_class_id');
        }
        
        Theme::model('locale/length_class');
        
        $data['length_classes'] = LocaleLengthClass::getLengthClasses();
        
        if (isset(Request::p()->post['ups_length'])) {
            $data['ups_length'] = Request::p()->post['ups_length'];
        } else {
            $data['ups_length'] = Config::get('ups_length');
        }
        
        if (isset(Request::p()->post['ups_width'])) {
            $data['ups_width'] = Request::p()->post['ups_width'];
        } else {
            $data['ups_width'] = Config::get('ups_width');
        }
        
        if (isset(Request::p()->post['ups_height'])) {
            $data['ups_height'] = Request::p()->post['ups_height'];
        } else {
            $data['ups_height'] = Config::get('ups_height');
        }
        
        if (isset(Request::p()->post['ups_tax_class_id'])) {
            $data['ups_tax_class_id'] = Request::p()->post['ups_tax_class_id'];
        } else {
            $data['ups_tax_class_id'] = Config::get('ups_tax_class_id');
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = LocaleTaxClass::getTaxClasses();
        
        if (isset(Request::p()->post['ups_geo_zone_id'])) {
            $data['ups_geo_zone_id'] = Request::p()->post['ups_geo_zone_id'];
        } else {
            $data['ups_geo_zone_id'] = Config::get('ups_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['ups_status'])) {
            $data['ups_status'] = Request::p()->post['ups_status'];
        } else {
            $data['ups_status'] = Config::get('ups_status');
        }
        
        if (isset(Request::p()->post['ups_sort_order'])) {
            $data['ups_sort_order'] = Request::p()->post['ups_sort_order'];
        } else {
            $data['ups_sort_order'] = Config::get('ups_sort_order');
        }
        
        if (isset(Request::p()->post['ups_debug'])) {
            $data['ups_debug'] = Request::p()->post['ups_debug'];
        } else {
            $data['ups_debug'] = Config::get('ups_debug');
        }
        
        Theme::loadjs('javascript/shipping/ups', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('shipping/ups', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/ups')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['ups_key']) {
            $this->error['key'] = Lang::get('lang_error_key');
        }
        
        if (!Request::p()->post['ups_username']) {
            $this->error['username'] = Lang::get('lang_error_username');
        }
        
        if (!Request::p()->post['ups_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!Request::p()->post['ups_city']) {
            $this->error['city'] = Lang::get('lang_error_city');
        }
        
        if (!Request::p()->post['ups_state']) {
            $this->error['state'] = Lang::get('lang_error_state');
        }
        
        if (!Request::p()->post['ups_country']) {
            $this->error['country'] = Lang::get('lang_error_country');
        }
        
        if (empty(Request::p()->post['ups_length'])) {
            $this->error['dimension'] = Lang::get('lang_error_dimension');
        }
        
        if (empty(Request::p()->post['ups_width'])) {
            $this->error['dimension'] = Lang::get('lang_error_dimension');
        }
        
        if (empty(Request::p()->post['ups_height'])) {
            $this->error['dimension'] = Lang::get('lang_error_dimension');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
