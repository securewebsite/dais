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

namespace App\Controllers\Admin\Payment;
use App\Controllers\Controller;

class FreeCheckout extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/free_checkout');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('freecheckout', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/free_checkout');
        
        $data['action'] = Url::link('payment/free_checkout', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['freecheckout_order_status_id'])) {
            $data['freecheckout_order_status_id'] = $this->request->post['freecheckout_order_status_id'];
        } else {
            $data['freecheckout_order_status_id'] = Config::get('freecheckout_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['freecheckout_status'])) {
            $data['freecheckout_status'] = $this->request->post['freecheckout_status'];
        } else {
            $data['freecheckout_status'] = Config::get('freecheckout_status');
        }
        
        if (isset($this->request->post['freecheckout_sort_order'])) {
            $data['freecheckout_sort_order'] = $this->request->post['freecheckout_sort_order'];
        } else {
            $data['freecheckout_sort_order'] = Config::get('freecheckout_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/free_checkout', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/freecheckout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
