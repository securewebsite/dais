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

namespace App\Controllers\Admin\Widget;

use App\Controllers\Controller;

class Latest extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/latest');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('latest', Request::post());
            Cache::delete('products.latest');
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = array();
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/latest');
        
        $data['action'] = Url::link('widget/latest', '', 'SSL');
        $data['cancel'] = Url::link('module/widget', '', 'SSL');
        
        $data['widgets'] = array();
        
        if (isset(Request::p()->post['latest_widget'])) {
            $data['widgets'] = Request::p()->post['latest_widget'];
        } elseif (Config::get('latest_widget')) {
            $data['widgets'] = Config::get('latest_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('javascript/widget/latest', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('widget/latest', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'widget/latest')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (isset(Request::p()->post['latest_widget'])) {
            foreach (Request::p()->post['latest_widget'] as $key => $value) {
                if (!$value['image_width'] || !$value['image_height']) {
                    $this->error['image'][$key] = Lang::get('lang_error_image');
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
