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
        $data = Theme::language('total/handling');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('handling', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/handling');
        
        $data['action'] = Url::link('total/handling', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['handling_total'])) {
            $data['handling_total'] = $this->request->post['handling_total'];
        } else {
            $data['handling_total'] = Config::get('handling_total');
        }
        
        if (isset($this->request->post['handling_fee'])) {
            $data['handling_fee'] = $this->request->post['handling_fee'];
        } else {
            $data['handling_fee'] = Config::get('handling_fee');
        }
        
        if (isset($this->request->post['handling_tax_class_id'])) {
            $data['handling_tax_class_id'] = $this->request->post['handling_tax_class_id'];
        } else {
            $data['handling_tax_class_id'] = Config::get('handling_tax_class_id');
        }
        
        Theme::model('localization/tax_class');
        
        $data['tax_classes'] = $this->model_localization_tax_class->getTaxClasses();
        
        if (isset($this->request->post['handling_status'])) {
            $data['handling_status'] = $this->request->post['handling_status'];
        } else {
            $data['handling_status'] = Config::get('handling_status');
        }
        
        if (isset($this->request->post['handling_sort_order'])) {
            $data['handling_sort_order'] = $this->request->post['handling_sort_order'];
        } else {
            $data['handling_sort_order'] = Config::get('handling_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('total/handling', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/handling')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
