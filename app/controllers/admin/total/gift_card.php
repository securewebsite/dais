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

class GiftCard extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('total/gift_card');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('gift_card', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_total', 'module/total');
        Breadcrumb::add('lang_heading_title', 'total/gift_card');
        
        $data['action'] = Url::link('total/gift_card', '', 'SSL');
        $data['cancel'] = Url::link('module/total', '', 'SSL');
        
        if (isset($this->request->post['gift_card_status'])) {
            $data['gift_card_status'] = $this->request->post['gift_card_status'];
        } else {
            $data['gift_card_status'] = Config::get('gift_card_status');
        }
        
        if (isset($this->request->post['gift_card_sort_order'])) {
            $data['gift_card_sort_order'] = $this->request->post['gift_card_sort_order'];
        } else {
            $data['gift_card_sort_order'] = Config::get('gift_card_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('total/gift_card', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'total/gift_card')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
