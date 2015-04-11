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

class Loworderfee extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('total/loworderfee');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('loworderfee', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_total', 'module/total');
        $this->breadcrumb->add('lang_heading_title', 'total/loworderfee');
        
        $data['action'] = $this->url->link('total/loworderfee', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['loworderfee_total'])) {
            $data['loworderfee_total'] = $this->request->post['loworderfee_total'];
        } else {
            $data['loworderfee_total'] = $this->config->get('loworderfee_total');
        }
        
        if (isset($this->request->post['loworderfee_fee'])) {
            $data['loworderfee_fee'] = $this->request->post['loworderfee_fee'];
        } else {
            $data['loworderfee_fee'] = $this->config->get('loworderfee_fee');
        }
        
        if (isset($this->request->post['loworderfee_tax_class_id'])) {
            $data['loworderfee_tax_class_id'] = $this->request->post['loworderfee_tax_class_id'];
        } else {
            $data['loworderfee_tax_class_id'] = $this->config->get('loworderfee_tax_class_id');
        }
        
        $this->theme->model('localization/taxclass');
        
        $data['tax_classes'] = $this->model_localization_taxclass->getTaxClasses();
        
        if (isset($this->request->post['loworderfee_status'])) {
            $data['loworderfee_status'] = $this->request->post['loworderfee_status'];
        } else {
            $data['loworderfee_status'] = $this->config->get('loworderfee_status');
        }
        
        if (isset($this->request->post['loworderfee_sort_order'])) {
            $data['loworderfee_sort_order'] = $this->request->post['loworderfee_sort_order'];
        } else {
            $data['loworderfee_sort_order'] = $this->config->get('loworderfee_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('total/loworderfee', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'total/loworderfee')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
