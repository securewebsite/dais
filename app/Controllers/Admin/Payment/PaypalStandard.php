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

namespace App\Controllers\Admin\Payment;
use App\Controllers\Controller;

class PaypalStandard extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/paypal_standard');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypalstandard', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_standard');
        
        $data['action'] = Url::link('payment/paypal_standard', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypalstandard_email'])) {
            $data['paypalstandard_email'] = $this->request->post['paypalstandard_email'];
        } else {
            $data['paypalstandard_email'] = Config::get('paypalstandard_email');
        }
        
        if (isset($this->request->post['paypalstandard_test'])) {
            $data['paypalstandard_test'] = $this->request->post['paypalstandard_test'];
        } else {
            $data['paypalstandard_test'] = Config::get('paypalstandard_test');
        }
        
        if (isset($this->request->post['paypalstandard_transaction'])) {
            $data['paypalstandard_transaction'] = $this->request->post['paypalstandard_transaction'];
        } else {
            $data['paypalstandard_transaction'] = Config::get('paypalstandard_transaction');
        }
        
        if (isset($this->request->post['paypalstandard_debug'])) {
            $data['paypalstandard_debug'] = $this->request->post['paypalstandard_debug'];
        } else {
            $data['paypalstandard_debug'] = Config::get('paypalstandard_debug');
        }
        
        if (isset($this->request->post['paypalstandard_total'])) {
            $data['paypalstandard_total'] = $this->request->post['paypalstandard_total'];
        } else {
            $data['paypalstandard_total'] = Config::get('paypalstandard_total');
        }
        
        if (isset($this->request->post['paypalstandard_canceled_reversal_status_id'])) {
            $data['paypalstandard_canceled_reversal_status_id'] = $this->request->post['paypalstandard_canceled_reversal_status_id'];
        } else {
            $data['paypalstandard_canceled_reversal_status_id'] = Config::get('paypalstandard_canceled_reversal_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_completed_status_id'])) {
            $data['paypalstandard_completed_status_id'] = $this->request->post['paypalstandard_completed_status_id'];
        } else {
            $data['paypalstandard_completed_status_id'] = Config::get('paypalstandard_completed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_denied_status_id'])) {
            $data['paypalstandard_denied_status_id'] = $this->request->post['paypalstandard_denied_status_id'];
        } else {
            $data['paypalstandard_denied_status_id'] = Config::get('paypalstandard_denied_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_expired_status_id'])) {
            $data['paypalstandard_expired_status_id'] = $this->request->post['paypalstandard_expired_status_id'];
        } else {
            $data['paypalstandard_expired_status_id'] = Config::get('paypalstandard_expired_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_failed_status_id'])) {
            $data['paypalstandard_failed_status_id'] = $this->request->post['paypalstandard_failed_status_id'];
        } else {
            $data['paypalstandard_failed_status_id'] = Config::get('paypalstandard_failed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_pending_status_id'])) {
            $data['paypalstandard_pending_status_id'] = $this->request->post['paypalstandard_pending_status_id'];
        } else {
            $data['paypalstandard_pending_status_id'] = Config::get('paypalstandard_pending_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_processed_status_id'])) {
            $data['paypalstandard_processed_status_id'] = $this->request->post['paypalstandard_processed_status_id'];
        } else {
            $data['paypalstandard_processed_status_id'] = Config::get('paypalstandard_processed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_refunded_status_id'])) {
            $data['paypalstandard_refunded_status_id'] = $this->request->post['paypalstandard_refunded_status_id'];
        } else {
            $data['paypalstandard_refunded_status_id'] = Config::get('paypalstandard_refunded_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_reversed_status_id'])) {
            $data['paypalstandard_reversed_status_id'] = $this->request->post['paypalstandard_reversed_status_id'];
        } else {
            $data['paypalstandard_reversed_status_id'] = Config::get('paypalstandard_reversed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_voided_status_id'])) {
            $data['paypalstandard_voided_status_id'] = $this->request->post['paypalstandard_voided_status_id'];
        } else {
            $data['paypalstandard_voided_status_id'] = Config::get('paypalstandard_voided_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypalstandard_geo_zone_id'])) {
            $data['paypalstandard_geo_zone_id'] = $this->request->post['paypalstandard_geo_zone_id'];
        } else {
            $data['paypalstandard_geo_zone_id'] = Config::get('paypalstandard_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypalstandard_status'])) {
            $data['paypalstandard_status'] = $this->request->post['paypalstandard_status'];
        } else {
            $data['paypalstandard_status'] = Config::get('paypalstandard_status');
        }
        
        if (isset($this->request->post['paypalstandard_sort_order'])) {
            $data['paypalstandard_sort_order'] = $this->request->post['paypalstandard_sort_order'];
        } else {
            $data['paypalstandard_sort_order'] = Config::get('paypalstandard_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_standard', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'payment/paypalstandard')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['paypalstandard_email']) {
            $this->error['email'] = Lang::get('lang_error_email');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
