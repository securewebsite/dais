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

class SideBarMenu extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/side_bar_menu');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('side_bar_menu', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/side_bar_menu');
        
        $data['action'] = Url::link('widget/side_bar_menu', '', 'SSL');
        $data['cancel'] = Url::link('module/widget', '', 'SSL');
        
        $data['widgets'] = array();
        
        if (isset(Request::p()->post['side_bar_menu_widget'])) {
            $data['widgets'] = Request::p()->post['side_bar_menu_widget'];
        } elseif (Config::get('side_bar_menu_widget')) {
            $data['widgets'] = Config::get('side_bar_menu_widget');
        }
        
        Theme::model('module/menu');
        
        $data['menus'] = array();
        
        $menus = ModuleMenu::getMenus();
        
        foreach ($menus as $menu):
            $data['menus'][] = array('menu_id' => $menu['menu_id'], 'name' => $menu['name']);
        endforeach;
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('javascript/widget/side_bar_menu', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('widget/side_bar_menu', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'widget/side_bar_menu')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
