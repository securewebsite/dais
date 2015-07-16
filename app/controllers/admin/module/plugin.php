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

namespace App\Controllers\Admin\Module;

use App\Controllers\Controller;

class Plugin extends Controller {
    
    public function index() {
        $data = Theme::language('module/plugin');
        Theme::setTitle(Lang::get('lang_heading_plugin'));
        
        Breadcrumb::add('lang_heading_plugin', 'module/plugin');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }
        
        Theme::model('setting/module');
        
        $modules = SettingModule::getInstalled('plugin');
        
        foreach ($modules as $key => $value) {
            $file = Config::get('path.plugin') . $value . '/register.php';
            
            if (!is_readable($file)) {
                SettingModule::uninstall('plugin', $value);
                unset($modules[$key]);
            }
        }
        
        $data['modules'] = array();
        
        $files = $this->plugin->getPlugins();
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file));
                
                $data = $this->plugin->language($module, $data);
                
                $action = array();
                
                if (!in_array($module, $modules)) {
                    $action[] = array('text' => Lang::get('lang_text_install'), 'href' => Url::link('module/plugin/install', '' . '&module=' . $module, 'SSL'));
                } else {
                    if (is_readable(Config::get('path.plugin') . $module . '/admin/controller/' . $module . '.php')):
                        $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('plugin/' . $module . '', '', 'SSL'));
                    endif;
                    
                    $action[] = array('text' => Lang::get('lang_text_uninstall'), 'href' => Url::link('module/plugin/uninstall', '' . '&module=' . $module, 'SSL'));
                }
                
                $data['modules'][] = array('name' => Lang::get('lang_heading_title'), 'action' => $action);
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('module/plugin', $data));
    }
    
    public function install() {
        Lang::load('module/plugin');
        
        if (!User::hasPermission('modify', 'module/plugin')) {
            $this->session->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            
            SettingModule::install('plugin', $this->request->get['module']);
            
            if (is_readable(Config::get('path.plugin') . $this->request->get['module'] . '/controller/' . $this->request->get['module'] . '.php')):
                Theme::model('people/user_group');
                
                PeopleUserGroup::addPermission(User::getId(), 'access', 'plugin/' . $this->request->get['module']);
                PeopleUserGroup::addPermission(User::getId(), 'modify', 'plugin/' . $this->request->get['module']);
            endif;
            
            $this->plugin->install($this->request->get['module']);
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/plugin');
        
        if (!User::hasPermission('modify', 'module/plugin')) {
            $this->session->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');
            
            SettingModule::uninstall('plugin', $this->request->get['module']);
            SettingSetting::deleteSetting($this->request->get['module']);
            
            $this->plugin->uninstall($this->request->get['module']);
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        }
    }
}
