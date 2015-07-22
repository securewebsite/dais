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

class Widget extends Controller {
    
    public function index() {
        $data = Theme::language('module/widget');
        Theme::setTitle(Lang::get('lang_heading_widget'));
        
        Breadcrumb::add('lang_heading_widget', 'module/widget');
        
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
        
        $modules = SettingModule::getInstalled('widget');
        
        foreach ($modules as $key => $value) {
            $class = Finder::find('widget' . SEP . $value);
            
            if (!$class):
                SettingModule::uninstall('widget', $value);
                unset($modules[$key]);
            endif;
        }
        
        $data['modules'] = [];
        
        $files = Theme::getFiles('widget');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('widget/' . $module, $data);
                
                $action = [];
                
                if (!in_array($module, $modules)) {
                    $action[] = array(
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/widget/install', '&widget=' . $module, 'SSL')
                    );
                } else {
                    $action[] = array(
                        'text' => Lang::get('lang_text_edit'), 
                        'href' => Url::link('widget/' . $module, '', 'SSL')
                    );
                    
                    $action[] = array(
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/widget/uninstall', '&widget=' . $module, 'SSL')
                    );
                }
                
                $data['modules'][] = array(
                    'name'   => Lang::get('lang_heading_title'), 
                    'action' => $action
                );
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/widget', $data));
    }
    
    public function install() {
        Lang::load('module/widget');
        
        if (!User::hasPermission('modify', 'module/widget')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        } else {
            Theme::model('setting/module');

            $widget =  Request::p()->get['widget'];
            
            SettingModule::install('widget', $widget);
            
            Theme::model('people/user_group');
            
            PeopleUserGroup::addPermission(User::getId(), 'access', 'widget' . SEP . $widget);
            PeopleUserGroup::addPermission(User::getId(), 'modify', 'widget' . SEP . $widget);
            
            $class = Finder::make('widget' . SEP . $widget);
            
            if (method_exists($class, 'install')):
                $class->install();
            endif;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/widget');
        
        if (!User::hasPermission('modify', 'module/widget')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');

            $widget = Request::p()->get['widget'];
            
            SettingModule::uninstall('widget', $widget);
            SettingSetting::deleteSetting($widget);
            
            $class = Finder::make('widget' . SEP . $widget);
            
            if (method_exists($class, 'uninstall')):
                $class->uninstall();
            endif;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        }
    }
}
