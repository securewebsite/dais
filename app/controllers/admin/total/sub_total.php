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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('sub_total', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/sub_total');
        
        $data['action'] = Url::link('total/sub_total', '', 'SSL');
        $data['cancel'] = Url::link('module/total', '', 'SSL');
        
        if (isset(Request::p()->post['sub_total_status'])) {
            $data['sub_total_status'] = Request::p()->post['sub_total_status'];
        } else {
            $data['sub_total_status'] = Config::get('sub_total_status');
        }
        
        if (isset(Request::p()->post['sub_total_sort_order'])) {
            $data['sub_total_sort_order'] = Request::p()->post['sub_total_sort_order'];
        } else {
            $data['sub_total_sort_order'] = Config::get('sub_total_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('total/sub_total', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/sub_total')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
