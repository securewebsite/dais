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
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset(Session::p()->data['error'])) {
            $data['error'] = Session::p()->data['error'];
            
            unset(Session::p()->data['error']);
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
        
        $files = \Plugin::getPlugins();
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file));
                
                $data = \Plugin::language($module, $data);
                
                $action = array();
                
                if (!in_array($module, $modules)) {
                    $action[] = [
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/plugin/install', 'plugin=' . $module, 'SSL')
                    ];
                } else {
                    if (is_readable(Config::get('path.plugin') . $module . '/admin/controllers/' . $module . '.php')):
                        $action[] = [
                            'text' => Lang::get('lang_text_edit'), 
                            'href' => Url::link('plugin/' . $module, '', 'SSL')
                        ];
                    endif;
                    
                    $action[] = [
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/plugin/uninstall', 'plugin=' . $module, 'SSL')
                    ];
                }
                
                $data['modules'][] = [
                    'name'   => Lang::get('lang_heading_title'), 
                    'action' => $action
                ];
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/plugin', $data));
    }
    
    public function install() {
        Lang::load('module/plugin');
        
        if (!User::hasPermission('modify', 'module/plugin')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        } else {
            Theme::model('setting/module');

            $plugin = Request::p()->get['plugin'];
            
            SettingModule::install('plugin', $plugin);
            
            if (is_readable(Config::get('path.plugin') . $plugin . '/admin/controllers/' . $plugin . '.php')):
                Theme::model('people/user_group');
                
                PeopleUserGroup::addPermission(User::getId(), 'access', 'plugin/' . $plugin);
                PeopleUserGroup::addPermission(User::getId(), 'modify', 'plugin/' . $plugin);
            endif;
            
            \Plugin::install($plugin);
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/plugin');
        
        if (!User::hasPermission('modify', 'module/plugin')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');

            $plugin = Request::p()->get['plugin'];
            
            SettingModule::uninstall('plugin', $plugin);
            SettingSetting::deleteSetting($plugin);
            
            \Plugin::uninstall($plugin);
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
        }
    }
}
