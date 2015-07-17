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

class Welcome extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/welcome');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('welcome', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/welcome');
        
        $data['action'] = Url::link('widget/welcome', '', 'SSL');
        $data['cancel'] = Url::link('module/widget', '', 'SSL');
        
        $data['widgets'] = array();
        
        if (isset(Request::p()->post['welcome_widget'])) {
            $data['widgets'] = Request::p()->post['welcome_widget'];
        } elseif (Config::get('welcome_widget')) {
            $data['widgets'] = Config::get('welcome_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        Theme::loadjs('javascript/widget/welcome', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('widget/welcome', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'widget/welcome')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
