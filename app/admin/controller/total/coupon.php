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

class Coupon extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/coupon');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('coupon', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            Response::redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_total', 'module/total');
        $this->breadcrumb->add('lang_heading_title', 'total/coupon');
        
        $data['action'] = $this->url->link('total/coupon', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['coupon_status'])) {
            $data['coupon_status'] = $this->request->post['coupon_status'];
        } else {
            $data['coupon_status'] = Config::get('coupon_status');
        }
        
        if (isset($this->request->post['coupon_sort_order'])) {
            $data['coupon_sort_order'] = $this->request->post['coupon_sort_order'];
        } else {
            $data['coupon_sort_order'] = Config::get('coupon_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('total/coupon', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/coupon')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
