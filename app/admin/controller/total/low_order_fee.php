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

namespace Admin\Controller\Total;
use Dais\Engine\Controller;

class LowOrderFee extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('total/low_order_fee');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('low_order_fee', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_total', 'module/total');
        $this->breadcrumb->add('lang_heading_title', 'total/low_order_fee');
        
        $data['action'] = $this->url->link('total/low_order_fee', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['low_order_fee_total'])) {
            $data['low_order_fee_total'] = $this->request->post['low_order_fee_total'];
        } else {
            $data['low_order_fee_total'] = $this->config->get('low_order_fee_total');
        }
        
        if (isset($this->request->post['low_order_fee_fee'])) {
            $data['low_order_fee_fee'] = $this->request->post['low_order_fee_fee'];
        } else {
            $data['low_order_fee_fee'] = $this->config->get('low_order_fee_fee');
        }
        
        if (isset($this->request->post['low_order_fee_tax_class_id'])) {
            $data['low_order_fee_tax_class_id'] = $this->request->post['low_order_fee_tax_class_id'];
        } else {
            $data['low_order_fee_tax_class_id'] = $this->config->get('low_order_fee_tax_class_id');
        }
        
        $this->theme->model('localization/tax_class');
        
        $data['tax_classes'] = $this->model_localization_tax_class->getTaxClasses();
        
        if (isset($this->request->post['low_order_fee_status'])) {
            $data['low_order_fee_status'] = $this->request->post['low_order_fee_status'];
        } else {
            $data['low_order_fee_status'] = $this->config->get('low_order_fee_status');
        }
        
        if (isset($this->request->post['low_order_fee_sort_order'])) {
            $data['low_order_fee_sort_order'] = $this->request->post['low_order_fee_sort_order'];
        } else {
            $data['low_order_fee_sort_order'] = $this->config->get('low_order_fee_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('total/low_order_fee', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'total/low_order_fee')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
