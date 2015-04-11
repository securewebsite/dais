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

class Paypalstandard extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/paypalstandard');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypalstandard', $this->request->post);
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
        $this->breadcrumb->add('lang_heading_title', 'payment/paypalstandard');
        
        $data['action'] = $this->url->link('payment/paypalstandard', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypalstandard_email'])) {
            $data['paypalstandard_email'] = $this->request->post['paypalstandard_email'];
        } else {
            $data['paypalstandard_email'] = $this->config->get('paypalstandard_email');
        }
        
        if (isset($this->request->post['paypalstandard_test'])) {
            $data['paypalstandard_test'] = $this->request->post['paypalstandard_test'];
        } else {
            $data['paypalstandard_test'] = $this->config->get('paypalstandard_test');
        }
        
        if (isset($this->request->post['paypalstandard_transaction'])) {
            $data['paypalstandard_transaction'] = $this->request->post['paypalstandard_transaction'];
        } else {
            $data['paypalstandard_transaction'] = $this->config->get('paypalstandard_transaction');
        }
        
        if (isset($this->request->post['paypalstandard_debug'])) {
            $data['paypalstandard_debug'] = $this->request->post['paypalstandard_debug'];
        } else {
            $data['paypalstandard_debug'] = $this->config->get('paypalstandard_debug');
        }
        
        if (isset($this->request->post['paypalstandard_total'])) {
            $data['paypalstandard_total'] = $this->request->post['paypalstandard_total'];
        } else {
            $data['paypalstandard_total'] = $this->config->get('paypalstandard_total');
        }
        
        if (isset($this->request->post['paypalstandard_canceled_reversal_status_id'])) {
            $data['paypalstandard_canceled_reversal_status_id'] = $this->request->post['paypalstandard_canceled_reversal_status_id'];
        } else {
            $data['paypalstandard_canceled_reversal_status_id'] = $this->config->get('paypalstandard_canceled_reversal_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_completed_status_id'])) {
            $data['paypalstandard_completed_status_id'] = $this->request->post['paypalstandard_completed_status_id'];
        } else {
            $data['paypalstandard_completed_status_id'] = $this->config->get('paypalstandard_completed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_denied_status_id'])) {
            $data['paypalstandard_denied_status_id'] = $this->request->post['paypalstandard_denied_status_id'];
        } else {
            $data['paypalstandard_denied_status_id'] = $this->config->get('paypalstandard_denied_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_expired_status_id'])) {
            $data['paypalstandard_expired_status_id'] = $this->request->post['paypalstandard_expired_status_id'];
        } else {
            $data['paypalstandard_expired_status_id'] = $this->config->get('paypalstandard_expired_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_failed_status_id'])) {
            $data['paypalstandard_failed_status_id'] = $this->request->post['paypalstandard_failed_status_id'];
        } else {
            $data['paypalstandard_failed_status_id'] = $this->config->get('paypalstandard_failed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_pending_status_id'])) {
            $data['paypalstandard_pending_status_id'] = $this->request->post['paypalstandard_pending_status_id'];
        } else {
            $data['paypalstandard_pending_status_id'] = $this->config->get('paypalstandard_pending_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_processed_status_id'])) {
            $data['paypalstandard_processed_status_id'] = $this->request->post['paypalstandard_processed_status_id'];
        } else {
            $data['paypalstandard_processed_status_id'] = $this->config->get('paypalstandard_processed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_refunded_status_id'])) {
            $data['paypalstandard_refunded_status_id'] = $this->request->post['paypalstandard_refunded_status_id'];
        } else {
            $data['paypalstandard_refunded_status_id'] = $this->config->get('paypalstandard_refunded_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_reversed_status_id'])) {
            $data['paypalstandard_reversed_status_id'] = $this->request->post['paypalstandard_reversed_status_id'];
        } else {
            $data['paypalstandard_reversed_status_id'] = $this->config->get('paypalstandard_reversed_status_id');
        }
        
        if (isset($this->request->post['paypalstandard_voided_status_id'])) {
            $data['paypalstandard_voided_status_id'] = $this->request->post['paypalstandard_voided_status_id'];
        } else {
            $data['paypalstandard_voided_status_id'] = $this->config->get('paypalstandard_voided_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['paypalstandard_geo_zone_id'])) {
            $data['paypalstandard_geo_zone_id'] = $this->request->post['paypalstandard_geo_zone_id'];
        } else {
            $data['paypalstandard_geo_zone_id'] = $this->config->get('paypalstandard_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['paypalstandard_status'])) {
            $data['paypalstandard_status'] = $this->request->post['paypalstandard_status'];
        } else {
            $data['paypalstandard_status'] = $this->config->get('paypalstandard_status');
        }
        
        if (isset($this->request->post['paypalstandard_sort_order'])) {
            $data['paypalstandard_sort_order'] = $this->request->post['paypalstandard_sort_order'];
        } else {
            $data['paypalstandard_sort_order'] = $this->config->get('paypalstandard_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/paypalstandard', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/paypalstandard')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['paypalstandard_email']) {
            $this->error['email'] = $this->language->get('lang_error_email');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
