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

namespace Admin\Controller\Shipping;
use Dais\Engine\Controller;

class Ups extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('shipping/ups');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('ups', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $this->breadcrumb->add('lang_text_shipping', 'module/shipping');
        $this->breadcrumb->add('lang_heading_title', 'shipping/ups');
        
        $data['action'] = $this->url->link('shipping/ups', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['ups_key'])) {
            $data['ups_key'] = $this->request->post['ups_key'];
        } else {
            $data['ups_key'] = $this->config->get('ups_key');
        }
        
        if (isset($this->request->post['ups_username'])) {
            $data['ups_username'] = $this->request->post['ups_username'];
        } else {
            $data['ups_username'] = $this->config->get('ups_username');
        }
        
        if (isset($this->request->post['ups_password'])) {
            $data['ups_password'] = $this->request->post['ups_password'];
        } else {
            $data['ups_password'] = $this->config->get('ups_password');
        }
        
        if (isset($this->request->post['ups_pickup'])) {
            $data['ups_pickup'] = $this->request->post['ups_pickup'];
        } else {
            $data['ups_pickup'] = $this->config->get('ups_pickup');
        }
        
        $data['pickups'] = array();
        
        $data['pickups'][] = array('value' => '01', 'text' => $this->language->get('lang_text_daily_pickup'));
        
        $data['pickups'][] = array('value' => '03', 'text' => $this->language->get('lang_text_customer_counter'));
        
        $data['pickups'][] = array('value' => '06', 'text' => $this->language->get('lang_text_one_time_pickup'));
        
        $data['pickups'][] = array('value' => '07', 'text' => $this->language->get('lang_text_on_call_air_pickup'));
        
        $data['pickups'][] = array('value' => '19', 'text' => $this->language->get('lang_text_letter_center'));
        
        $data['pickups'][] = array('value' => '20', 'text' => $this->language->get('lang_text_air_service_center'));
        
        $data['pickups'][] = array('value' => '11', 'text' => $this->language->get('lang_text_suggested_retail_rates'));
        
        if (isset($this->request->post['ups_packaging'])) {
            $data['ups_packaging'] = $this->request->post['ups_packaging'];
        } else {
            $data['ups_packaging'] = $this->config->get('ups_packaging');
        }
        
        $data['packages'] = array();
        
        $data['packages'][] = array('value' => '02', 'text' => $this->language->get('lang_text_package'));
        
        $data['packages'][] = array('value' => '01', 'text' => $this->language->get('lang_text_ups_letter'));
        
        $data['packages'][] = array('value' => '03', 'text' => $this->language->get('lang_text_ups_tube'));
        
        $data['packages'][] = array('value' => '04', 'text' => $this->language->get('lang_text_ups_pak'));
        
        $data['packages'][] = array('value' => '21', 'text' => $this->language->get('lang_text_ups_express_box'));
        
        $data['packages'][] = array('value' => '24', 'text' => $this->language->get('lang_text_ups_25kg_box'));
        
        $data['packages'][] = array('value' => '25', 'text' => $this->language->get('lang_text_ups_10kg_box'));
        
        if (isset($this->request->post['ups_classification'])) {
            $data['ups_classification'] = $this->request->post['ups_classification'];
        } else {
            $data['ups_classification'] = $this->config->get('ups_classification');
        }
        
        $data['classifications'][] = array('value' => '01', 'text' => '01');
        
        $data['classifications'][] = array('value' => '03', 'text' => '03');
        
        $data['classifications'][] = array('value' => '04', 'text' => '04');
        
        if (isset($this->request->post['ups_origin'])) {
            $data['ups_origin'] = $this->request->post['ups_origin'];
        } else {
            $data['ups_origin'] = $this->config->get('ups_origin');
        }
        
        $data['origins'] = array();
        
        $data['origins'][] = array('value' => 'US', 'text' => $this->language->get('lang_text_us'));
        
        $data['origins'][] = array('value' => 'CA', 'text' => $this->language->get('lang_text_ca'));
        
        $data['origins'][] = array('value' => 'EU', 'text' => $this->language->get('lang_text_eu'));
        
        $data['origins'][] = array('value' => 'PR', 'text' => $this->language->get('lang_text_pr'));
        
        $data['origins'][] = array('value' => 'MX', 'text' => $this->language->get('lang_text_mx'));
        
        $data['origins'][] = array('value' => 'other', 'text' => $this->language->get('lang_text_other'));
        
        if (isset($this->request->post['ups_city'])) {
            $data['ups_city'] = $this->request->post['ups_city'];
        } else {
            $data['ups_city'] = $this->config->get('ups_city');
        }
        
        if (isset($this->request->post['ups_state'])) {
            $data['ups_state'] = $this->request->post['ups_state'];
        } else {
            $data['ups_state'] = $this->config->get('ups_state');
        }
        
        if (isset($this->request->post['ups_country'])) {
            $data['ups_country'] = $this->request->post['ups_country'];
        } else {
            $data['ups_country'] = $this->config->get('ups_country');
        }
        
        if (isset($this->request->post['ups_postcode'])) {
            $data['ups_postcode'] = $this->request->post['ups_postcode'];
        } else {
            $data['ups_postcode'] = $this->config->get('ups_postcode');
        }
        
        if (isset($this->request->post['ups_test'])) {
            $data['ups_test'] = $this->request->post['ups_test'];
        } else {
            $data['ups_test'] = $this->config->get('ups_test');
        }
        
        if (isset($this->request->post['ups_quote_type'])) {
            $data['ups_quote_type'] = $this->request->post['ups_quote_type'];
        } else {
            $data['ups_quote_type'] = $this->config->get('ups_quote_type');
        }
        
        $data['quote_types'] = array();
        
        $data['quote_types'][] = array('value' => 'residential', 'text' => $this->language->get('lang_text_residential'));
        
        $data['quote_types'][] = array('value' => 'commercial', 'text' => $this->language->get('lang_text_commercial'));
        
        // US
        if (isset($this->request->post['ups_us_01'])) {
            $data['ups_us_01'] = $this->request->post['ups_us_01'];
        } else {
            $data['ups_us_01'] = $this->config->get('ups_us_01');
        }
        
        if (isset($this->request->post['ups_us_02'])) {
            $data['ups_us_02'] = $this->request->post['ups_us_02'];
        } else {
            $data['ups_us_02'] = $this->config->get('ups_us_02');
        }
        
        if (isset($this->request->post['ups_us_03'])) {
            $data['ups_us_03'] = $this->request->post['ups_us_03'];
        } else {
            $data['ups_us_03'] = $this->config->get('ups_us_03');
        }
        
        if (isset($this->request->post['ups_us_07'])) {
            $data['ups_us_07'] = $this->request->post['ups_us_07'];
        } else {
            $data['ups_us_07'] = $this->config->get('ups_us_07');
        }
        
        if (isset($this->request->post['ups_us_08'])) {
            $data['ups_us_08'] = $this->request->post['ups_us_08'];
        } else {
            $data['ups_us_08'] = $this->config->get('ups_us_08');
        }
        
        if (isset($this->request->post['ups_us_11'])) {
            $data['ups_us_11'] = $this->request->post['ups_us_11'];
        } else {
            $data['ups_us_11'] = $this->config->get('ups_us_11');
        }
        
        if (isset($this->request->post['ups_us_12'])) {
            $data['ups_us_12'] = $this->request->post['ups_us_12'];
        } else {
            $data['ups_us_12'] = $this->config->get('ups_us_12');
        }
        
        if (isset($this->request->post['ups_us_13'])) {
            $data['ups_us_13'] = $this->request->post['ups_us_13'];
        } else {
            $data['ups_us_13'] = $this->config->get('ups_us_13');
        }
        
        if (isset($this->request->post['ups_us_14'])) {
            $data['ups_us_14'] = $this->request->post['ups_us_14'];
        } else {
            $data['ups_us_14'] = $this->config->get('ups_us_14');
        }
        
        if (isset($this->request->post['ups_us_54'])) {
            $data['ups_us_54'] = $this->request->post['ups_us_54'];
        } else {
            $data['ups_us_54'] = $this->config->get('ups_us_54');
        }
        
        if (isset($this->request->post['ups_us_59'])) {
            $data['ups_us_59'] = $this->request->post['ups_us_59'];
        } else {
            $data['ups_us_59'] = $this->config->get('ups_us_59');
        }
        
        if (isset($this->request->post['ups_us_65'])) {
            $data['ups_us_65'] = $this->request->post['ups_us_65'];
        } else {
            $data['ups_us_65'] = $this->config->get('ups_us_65');
        }
        
        // Puerto Rico
        if (isset($this->request->post['ups_pr_01'])) {
            $data['ups_pr_01'] = $this->request->post['ups_pr_01'];
        } else {
            $data['ups_pr_01'] = $this->config->get('ups_pr_01');
        }
        
        if (isset($this->request->post['ups_pr_02'])) {
            $data['ups_pr_02'] = $this->request->post['ups_pr_02'];
        } else {
            $data['ups_pr_02'] = $this->config->get('ups_pr_02');
        }
        
        if (isset($this->request->post['ups_pr_03'])) {
            $data['ups_pr_03'] = $this->request->post['ups_pr_03'];
        } else {
            $data['ups_pr_03'] = $this->config->get('ups_pr_03');
        }
        
        if (isset($this->request->post['ups_pr_07'])) {
            $data['ups_pr_07'] = $this->request->post['ups_pr_07'];
        } else {
            $data['ups_pr_07'] = $this->config->get('ups_pr_07');
        }
        
        if (isset($this->request->post['ups_pr_08'])) {
            $data['ups_pr_08'] = $this->request->post['ups_pr_08'];
        } else {
            $data['ups_pr_08'] = $this->config->get('ups_pr_08');
        }
        
        if (isset($this->request->post['ups_pr_14'])) {
            $data['ups_pr_14'] = $this->request->post['ups_pr_14'];
        } else {
            $data['ups_pr_14'] = $this->config->get('ups_pr_14');
        }
        
        if (isset($this->request->post['ups_pr_54'])) {
            $data['ups_pr_54'] = $this->request->post['ups_pr_54'];
        } else {
            $data['ups_pr_54'] = $this->config->get('ups_pr_54');
        }
        
        if (isset($this->request->post['ups_pr_65'])) {
            $data['ups_pr_65'] = $this->request->post['ups_pr_65'];
        } else {
            $data['ups_pr_65'] = $this->config->get('ups_pr_65');
        }
        
        // Canada
        if (isset($this->request->post['ups_ca_01'])) {
            $data['ups_ca_01'] = $this->request->post['ups_ca_01'];
        } else {
            $data['ups_ca_01'] = $this->config->get('ups_ca_01');
        }
        
        if (isset($this->request->post['ups_ca_02'])) {
            $data['ups_ca_02'] = $this->request->post['ups_ca_02'];
        } else {
            $data['ups_ca_02'] = $this->config->get('ups_ca_02');
        }
        
        if (isset($this->request->post['ups_ca_07'])) {
            $data['ups_ca_07'] = $this->request->post['ups_ca_07'];
        } else {
            $data['ups_ca_07'] = $this->config->get('ups_ca_07');
        }
        
        if (isset($this->request->post['ups_ca_08'])) {
            $data['ups_ca_08'] = $this->request->post['ups_ca_08'];
        } else {
            $data['ups_ca_08'] = $this->config->get('ups_ca_08');
        }
        
        if (isset($this->request->post['ups_ca_11'])) {
            $data['ups_ca_11'] = $this->request->post['ups_ca_11'];
        } else {
            $data['ups_ca_11'] = $this->config->get('ups_ca_11');
        }
        
        if (isset($this->request->post['ups_ca_12'])) {
            $data['ups_ca_12'] = $this->request->post['ups_ca_12'];
        } else {
            $data['ups_ca_12'] = $this->config->get('ups_ca_12');
        }
        
        if (isset($this->request->post['ups_ca_13'])) {
            $data['ups_ca_13'] = $this->request->post['ups_ca_13'];
        } else {
            $data['ups_ca_13'] = $this->config->get('ups_ca_13');
        }
        
        if (isset($this->request->post['ups_ca_14'])) {
            $data['ups_ca_14'] = $this->request->post['ups_ca_14'];
        } else {
            $data['ups_ca_14'] = $this->config->get('ups_ca_14');
        }
        
        if (isset($this->request->post['ups_ca_54'])) {
            $data['ups_ca_54'] = $this->request->post['ups_ca_54'];
        } else {
            $data['ups_ca_54'] = $this->config->get('ups_ca_54');
        }
        
        if (isset($this->request->post['ups_ca_65'])) {
            $data['ups_ca_65'] = $this->request->post['ups_ca_65'];
        } else {
            $data['ups_ca_65'] = $this->config->get('ups_ca_65');
        }
        
        // Mexico
        if (isset($this->request->post['ups_mx_07'])) {
            $data['ups_mx_07'] = $this->request->post['ups_mx_07'];
        } else {
            $data['ups_mx_07'] = $this->config->get('ups_mx_07');
        }
        
        if (isset($this->request->post['ups_mx_08'])) {
            $data['ups_mx_08'] = $this->request->post['ups_mx_08'];
        } else {
            $data['ups_mx_08'] = $this->config->get('ups_mx_08');
        }
        
        if (isset($this->request->post['ups_mx_54'])) {
            $data['ups_mx_54'] = $this->request->post['ups_mx_54'];
        } else {
            $data['ups_mx_54'] = $this->config->get('ups_mx_54');
        }
        
        if (isset($this->request->post['ups_mx_65'])) {
            $data['ups_mx_65'] = $this->request->post['ups_mx_65'];
        } else {
            $data['ups_mx_65'] = $this->config->get('ups_mx_65');
        }
        
        // EU
        if (isset($this->request->post['ups_eu_07'])) {
            $data['ups_eu_07'] = $this->request->post['ups_eu_07'];
        } else {
            $data['ups_eu_07'] = $this->config->get('ups_eu_07');
        }
        
        if (isset($this->request->post['ups_eu_08'])) {
            $data['ups_eu_08'] = $this->request->post['ups_eu_08'];
        } else {
            $data['ups_eu_08'] = $this->config->get('ups_eu_08');
        }
        
        if (isset($this->request->post['ups_eu_11'])) {
            $data['ups_eu_11'] = $this->request->post['ups_eu_11'];
        } else {
            $data['ups_eu_11'] = $this->config->get('ups_eu_11');
        }
        
        if (isset($this->request->post['ups_eu_54'])) {
            $data['ups_eu_54'] = $this->request->post['ups_eu_54'];
        } else {
            $data['ups_eu_54'] = $this->config->get('ups_eu_54');
        }
        
        if (isset($this->request->post['ups_eu_65'])) {
            $data['ups_eu_65'] = $this->request->post['ups_eu_65'];
        } else {
            $data['ups_eu_65'] = $this->config->get('ups_eu_65');
        }
        
        if (isset($this->request->post['ups_eu_82'])) {
            $data['ups_eu_82'] = $this->request->post['ups_eu_82'];
        } else {
            $data['ups_eu_82'] = $this->config->get('ups_eu_82');
        }
        
        if (isset($this->request->post['ups_eu_83'])) {
            $data['ups_eu_83'] = $this->request->post['ups_eu_83'];
        } else {
            $data['ups_eu_83'] = $this->config->get('ups_eu_83');
        }
        
        if (isset($this->request->post['ups_eu_84'])) {
            $data['ups_eu_84'] = $this->request->post['ups_eu_84'];
        } else {
            $data['ups_eu_84'] = $this->config->get('ups_eu_84');
        }
        
        if (isset($this->request->post['ups_eu_85'])) {
            $data['ups_eu_85'] = $this->request->post['ups_eu_85'];
        } else {
            $data['ups_eu_85'] = $this->config->get('ups_eu_85');
        }
        
        if (isset($this->request->post['ups_eu_86'])) {
            $data['ups_eu_86'] = $this->request->post['ups_eu_86'];
        } else {
            $data['ups_eu_86'] = $this->config->get('ups_eu_86');
        }
        
        // Other
        if (isset($this->request->post['ups_other_07'])) {
            $data['ups_other_07'] = $this->request->post['ups_other_07'];
        } else {
            $data['ups_other_07'] = $this->config->get('ups_other_07');
        }
        
        if (isset($this->request->post['ups_other_08'])) {
            $data['ups_other_08'] = $this->request->post['ups_other_08'];
        } else {
            $data['ups_other_08'] = $this->config->get('ups_other_08');
        }
        
        if (isset($this->request->post['ups_other_11'])) {
            $data['ups_other_11'] = $this->request->post['ups_other_11'];
        } else {
            $data['ups_other_11'] = $this->config->get('ups_other_11');
        }
        
        if (isset($this->request->post['ups_other_54'])) {
            $data['ups_other_54'] = $this->request->post['ups_other_54'];
        } else {
            $data['ups_other_54'] = $this->config->get('ups_other_54');
        }
        
        if (isset($this->request->post['ups_other_65'])) {
            $data['ups_other_65'] = $this->request->post['ups_other_65'];
        } else {
            $data['ups_other_65'] = $this->config->get('ups_other_65');
        }
        
        if (isset($this->request->post['ups_display_weight'])) {
            $data['ups_display_weight'] = $this->request->post['ups_display_weight'];
        } else {
            $data['ups_display_weight'] = $this->config->get('ups_display_weight');
        }
        
        if (isset($this->request->post['ups_insurance'])) {
            $data['ups_insurance'] = $this->request->post['ups_insurance'];
        } else {
            $data['ups_insurance'] = $this->config->get('ups_insurance');
        }
        
        if (isset($this->request->post['ups_weight_class_id'])) {
            $data['ups_weight_class_id'] = $this->request->post['ups_weight_class_id'];
        } else {
            $data['ups_weight_class_id'] = $this->config->get('ups_weight_class_id');
        }
        
        $this->theme->model('localization/weight_class');
        
        $data['weight_classes'] = $this->model_localization_weight_class->getWeightClasses();
        
        if (isset($this->request->post['ups_length_code'])) {
            $data['ups_length_code'] = $this->request->post['ups_length_code'];
        } else {
            $data['ups_length_code'] = $this->config->get('ups_length_code');
        }
        
        if (isset($this->request->post['ups_length_class_id'])) {
            $data['ups_length_class_id'] = $this->request->post['ups_length_class_id'];
        } else {
            $data['ups_length_class_id'] = $this->config->get('ups_length_class_id');
        }
        
        $this->theme->model('localization/length_class');
        
        $data['length_classes'] = $this->model_localization_length_class->getLengthClasses();
        
        if (isset($this->request->post['ups_length'])) {
            $data['ups_length'] = $this->request->post['ups_length'];
        } else {
            $data['ups_length'] = $this->config->get('ups_length');
        }
        
        if (isset($this->request->post['ups_width'])) {
            $data['ups_width'] = $this->request->post['ups_width'];
        } else {
            $data['ups_width'] = $this->config->get('ups_width');
        }
        
        if (isset($this->request->post['ups_height'])) {
            $data['ups_height'] = $this->request->post['ups_height'];
        } else {
            $data['ups_height'] = $this->config->get('ups_height');
        }
        
        if (isset($this->request->post['ups_tax_class_id'])) {
            $data['ups_tax_class_id'] = $this->request->post['ups_tax_class_id'];
        } else {
            $data['ups_tax_class_id'] = $this->config->get('ups_tax_class_id');
        }
        
        $this->theme->model('localization/tax_class');
        
        $data['tax_classes'] = $this->model_localization_tax_class->getTaxClasses();
        
        if (isset($this->request->post['ups_geo_zone_id'])) {
            $data['ups_geo_zone_id'] = $this->request->post['ups_geo_zone_id'];
        } else {
            $data['ups_geo_zone_id'] = $this->config->get('ups_geo_zone_id');
        }
        
        $this->theme->model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['ups_status'])) {
            $data['ups_status'] = $this->request->post['ups_status'];
        } else {
            $data['ups_status'] = $this->config->get('ups_status');
        }
        
        if (isset($this->request->post['ups_sort_order'])) {
            $data['ups_sort_order'] = $this->request->post['ups_sort_order'];
        } else {
            $data['ups_sort_order'] = $this->config->get('ups_sort_order');
        }
        
        if (isset($this->request->post['ups_debug'])) {
            $data['ups_debug'] = $this->request->post['ups_debug'];
        } else {
            $data['ups_debug'] = $this->config->get('ups_debug');
        }
        
        $this->theme->loadjs('javascript/shipping/ups', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('shipping/ups', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'shipping/ups')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['ups_key']) {
            $this->error['key'] = $this->language->get('lang_error_key');
        }
        
        if (!$this->request->post['ups_username']) {
            $this->error['username'] = $this->language->get('lang_error_username');
        }
        
        if (!$this->request->post['ups_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if (!$this->request->post['ups_city']) {
            $this->error['city'] = $this->language->get('lang_error_city');
        }
        
        if (!$this->request->post['ups_state']) {
            $this->error['state'] = $this->language->get('lang_error_state');
        }
        
        if (!$this->request->post['ups_country']) {
            $this->error['country'] = $this->language->get('lang_error_country');
        }
        
        if (empty($this->request->post['ups_length'])) {
            $this->error['dimension'] = $this->language->get('lang_error_dimension');
        }
        
        if (empty($this->request->post['ups_width'])) {
            $this->error['dimension'] = $this->language->get('lang_error_dimension');
        }
        
        if (empty($this->request->post['ups_height'])) {
            $this->error['dimension'] = $this->language->get('lang_error_dimension');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
