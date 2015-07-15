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

namespace App\Controllers\Admin\Total;

use App\Controllers\Controller;

class Tax extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/tax');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('tax', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/tax');
        
        $data['action'] = Url::link('total/tax', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['tax_status'])) {
            $data['tax_status'] = $this->request->post['tax_status'];
        } else {
            $data['tax_status'] = Config::get('tax_status');
        }
        
        if (isset($this->request->post['tax_sort_order'])) {
            $data['tax_sort_order'] = $this->request->post['tax_sort_order'];
        } else {
            $data['tax_sort_order'] = Config::get('tax_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('total/tax', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/tax')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
