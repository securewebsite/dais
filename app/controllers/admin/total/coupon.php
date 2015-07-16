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

class Coupon extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('coupon', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/coupon');
        
        $data['action'] = Url::link('total/coupon', '', 'SSL');
        $data['cancel'] = Url::link('module/total', '', 'SSL');
        
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
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('total/coupon', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/coupon')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
