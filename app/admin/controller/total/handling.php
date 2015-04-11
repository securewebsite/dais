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

class Handling extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('total/handling');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('handling', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_total', 'module/total');
        $this->breadcrumb->add('lang_heading_title', 'total/handling');
        
        $data['action'] = $this->url->link('total/handling', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['handling_total'])) {
            $data['handling_total'] = $this->request->post['handling_total'];
        } else {
            $data['handling_total'] = $this->config->get('handling_total');
        }
        
        if (isset($this->request->post['handling_fee'])) {
            $data['handling_fee'] = $this->request->post['handling_fee'];
        } else {
            $data['handling_fee'] = $this->config->get('handling_fee');
        }
        
        if (isset($this->request->post['handling_tax_class_id'])) {
            $data['handling_tax_class_id'] = $this->request->post['handling_tax_class_id'];
        } else {
            $data['handling_tax_class_id'] = $this->config->get('handling_tax_class_id');
        }
        
        $this->theme->model('localization/taxclass');
        
        $data['tax_classes'] = $this->model_localization_taxclass->getTaxClasses();
        
        if (isset($this->request->post['handling_status'])) {
            $data['handling_status'] = $this->request->post['handling_status'];
        } else {
            $data['handling_status'] = $this->config->get('handling_status');
        }
        
        if (isset($this->request->post['handling_sort_order'])) {
            $data['handling_sort_order'] = $this->request->post['handling_sort_order'];
        } else {
            $data['handling_sort_order'] = $this->config->get('handling_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('total/handling', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'total/handling')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
