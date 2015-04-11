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

class Total extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('total/total');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('total', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_total', 'module/total');
        $this->breadcrumb->add('lang_heading_title', 'total/total');
        
        $data['action'] = $this->url->link('total/total', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['total_status'])) {
            $data['total_status'] = $this->request->post['total_status'];
        } else {
            $data['total_status'] = $this->config->get('total_status');
        }
        
        if (isset($this->request->post['total_sort_order'])) {
            $data['total_sort_order'] = $this->request->post['total_sort_order'];
        } else {
            $data['total_sort_order'] = $this->config->get('total_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('total/total', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'total/total')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
