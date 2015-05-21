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

namespace Admin\Controller\Payment;
use Dais\Engine\Controller;

class PaypalStandard extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/paypal_standard');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypal_standard', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/paypal_standard');
        
        $data['action'] = $this->url->link('payment/paypal_standard', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypal_standard_email'])) {
            $data['paypal_standard_email'] = $this->request->post['paypal_standard_email'];
        } else {
            $data['paypal_standard_email'] = $this->config->get('paypal_standard_email');
        }
        
        if (isset($this->request->post['paypal_standard_test'])) {
            $data['paypal_standard_test'] = $this->request->post['paypal_standard_test'];
        } else {
            $data['paypal_standard_test'] = $this->config->get('paypal_standard_test');
        }
        
        if (isset($this->request->post['paypal_standard_transaction'])) {
            $data['paypal_standard_transaction'] = $this->request->post['paypal_standard_transaction'];
        } else {
            $data['paypal_standard_transaction'] = $this->config->get('paypal_standard_transaction');
        }
        
        if (isset($this->request->post['paypal_standard_debug'])) {
            $data['paypal_standard_debug'] = $this->request->post['paypal_standard_debug'];
        } else {
            $data['paypal_standard_debug'] = $this->config->get('paypal_standard_debug');
        }
        
        if (isset($this->request->post['paypal_standard_total'])) {
            $data['paypal_standard_total'] = $this->request->post['paypal_standard_total'];
        } else {
            $data['paypal_standard_total'] = $this->config->get('paypal_standard_total');
        }
        
        if (isset($this->request->post['paypal_standard_canceled_reversal_status_id'])) {
            $data['paypal_standard_canceled_reversal_status_id'] = $this->request->post['paypal_standard_canceled_reversal_status_id'];
        } else {
            $data['paypal_standard_canceled_reversal_status_id'] = $this->config->get('paypal_standard_canceled_reversal_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_completed_status_id'])) {
            $data['paypal_standard_completed_status_id'] = $this->request->post['paypal_standard_completed_status_id'];
        } else {
            $data['paypal_standard_completed_status_id'] = $this->config->get('paypal_standard_completed_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_denied_status_id'])) {
            $data['paypal_standard_denied_status_id'] = $this->request->post['paypal_standard_denied_status_id'];
        } else {
            $data['paypal_standard_denied_status_id'] = $this->config->get('paypal_standard_denied_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_expired_status_id'])) {
            $data['paypal_standard_expired_status_id'] = $this->request->post['paypal_standard_expired_status_id'];
        } else {
            $data['paypal_standard_expired_status_id'] = $this->config->get('paypal_standard_expired_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_failed_status_id'])) {
            $data['paypal_standard_failed_status_id'] = $this->request->post['paypal_standard_failed_status_id'];
        } else {
            $data['paypal_standard_failed_status_id'] = $this->config->get('paypal_standard_failed_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_pending_status_id'])) {
            $data['paypal_standard_pending_status_id'] = $this->request->post['paypal_standard_pending_status_id'];
        } else {
            $data['paypal_standard_pending_status_id'] = $this->config->get('paypal_standard_pending_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_processed_status_id'])) {
            $data['paypal_standard_processed_status_id'] = $this->request->post['paypal_standard_processed_status_id'];
        } else {
            $data['paypal_standard_processed_status_id'] = $this->config->get('paypal_standard_processed_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_refunded_status_id'])) {
            $data['paypal_standard_refunded_status_id'] = $this->request->post['paypal_standard_refunded_status_id'];
        } else {
            $data['paypal_standard_refunded_status_id'] = $this->config->get('paypal_standard_refunded_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_reversed_status_id'])) {
            $data['paypal_standard_reversed_status_id'] = $this->request->post['paypal_standard_reversed_status_id'];
        } else {
            $data['paypal_standard_reversed_status_id'] = $this->config->get('paypal_standard_reversed_status_id');
        }
        
        if (isset($this->request->post['paypal_standard_voided_status_id'])) {
            $data['paypal_standard_voided_status_id'] = $this->request->post['paypal_standard_voided_status_id'];
        } else {
            $data['paypal_standard_voided_status_id'] = $this->config->get('paypal_standard_voided_status_id');
        }
        
        $this->theme->model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypal_standard_geo_zone_id'])) {
            $data['paypal_standard_geo_zone_id'] = $this->request->post['paypal_standard_geo_zone_id'];
        } else {
            $data['paypal_standard_geo_zone_id'] = $this->config->get('paypal_standard_geo_zone_id');
        }
        
        $this->theme->model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypal_standard_status'])) {
            $data['paypal_standard_status'] = $this->request->post['paypal_standard_status'];
        } else {
            $data['paypal_standard_status'] = $this->config->get('paypal_standard_status');
        }
        
        if (isset($this->request->post['paypal_standard_sort_order'])) {
            $data['paypal_standard_sort_order'] = $this->request->post['paypal_standard_sort_order'];
        } else {
            $data['paypal_standard_sort_order'] = $this->config->get('paypal_standard_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/paypal_standard', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/paypal_standard')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['paypal_standard_email']) {
            $this->error['email'] = $this->language->get('lang_error_email');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}