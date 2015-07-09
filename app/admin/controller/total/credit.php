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

class Credit extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/credit');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('credit', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/credit');
        
        $data['action'] = Url::link('total/credit', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['credit_status'])) {
            $data['credit_status'] = $this->request->post['credit_status'];
        } else {
            $data['credit_status'] = Config::get('credit_status');
        }
        
        if (isset($this->request->post['credit_sort_order'])) {
            $data['credit_sort_order'] = $this->request->post['credit_sort_order'];
        } else {
            $data['credit_sort_order'] = Config::get('credit_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('total/credit', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/credit')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
