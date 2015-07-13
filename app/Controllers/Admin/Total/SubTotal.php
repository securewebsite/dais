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

class SubTotal extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/sub_total');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('subtotal', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/sub_total');
        
        $data['action'] = Url::link('total/sub_total', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['subtotal_status'])) {
            $data['subtotal_status'] = $this->request->post['subtotal_status'];
        } else {
            $data['subtotal_status'] = Config::get('subtotal_status');
        }
        
        if (isset($this->request->post['subtotal_sort_order'])) {
            $data['subtotal_sort_order'] = $this->request->post['subtotal_sort_order'];
        } else {
            $data['subtotal_sort_order'] = Config::get('subtotal_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('total/sub_total', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/subtotal')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
