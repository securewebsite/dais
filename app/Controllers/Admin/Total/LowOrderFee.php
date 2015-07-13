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

class LowOrderFee extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/low_order_fee');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('loworderfee', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/low_order_fee');
        
        $data['action'] = Url::link('total/low_order_fee', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['loworderfee_total'])) {
            $data['loworderfee_total'] = $this->request->post['loworderfee_total'];
        } else {
            $data['loworderfee_total'] = Config::get('loworderfee_total');
        }
        
        if (isset($this->request->post['loworderfee_fee'])) {
            $data['loworderfee_fee'] = $this->request->post['loworderfee_fee'];
        } else {
            $data['loworderfee_fee'] = Config::get('loworderfee_fee');
        }
        
        if (isset($this->request->post['loworderfee_tax_class_id'])) {
            $data['loworderfee_tax_class_id'] = $this->request->post['loworderfee_tax_class_id'];
        } else {
            $data['loworderfee_tax_class_id'] = Config::get('loworderfee_tax_class_id');
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = $this->model_locale_tax_class->getTaxClasses();
        
        if (isset($this->request->post['loworderfee_status'])) {
            $data['loworderfee_status'] = $this->request->post['loworderfee_status'];
        } else {
            $data['loworderfee_status'] = Config::get('loworderfee_status');
        }
        
        if (isset($this->request->post['loworderfee_sort_order'])) {
            $data['loworderfee_sort_order'] = $this->request->post['loworderfee_sort_order'];
        } else {
            $data['loworderfee_sort_order'] = Config::get('loworderfee_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('total/low_order_fee', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/loworderfee')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
