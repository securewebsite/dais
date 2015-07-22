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

class Feed extends Controller {
    
    public function index() {
        $data = Theme::language('module/feed');
        Theme::setTitle(Lang::get('lang_heading_feed'));
        
        Breadcrumb::add('lang_heading_feed', 'module/feed');
        
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
        
        $modules = SettingModule::getInstalled('feed');
        
        foreach ($modules as $key => $value):
            $class = Finder::find('feed' . SEP . $value);
            
            if (!$class):
                SettingModule::uninstall('feed', $value);
                unset($modules[$key]);
            endif;
        endforeach;
        
        $data['modules'] = array();
        
        $files = Theme::getFiles('feed');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('feed/' . $module, $data);
                
                $action = [];
                
                if (!in_array($module, $modules)) {
                    $action[] = [
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/feed/install', 'feed=' . $module, 'SSL')
                    ];
                } else {
                    $action[] = [
                        'text' => Lang::get('lang_text_edit'), 
                        'href' => Url::link('feed/' . $module, '', 'SSL')
                    ];
                    
                    $action[] = [
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/feed/uninstall', 'feed=' . $module, 'SSL')
                    ];
                }
                
                $data['modules'][] = [
                    'name'   => Lang::get('lang_heading_title'), 
                    'status' => Config::get($module . '_status') ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled'), 
                    'action' => $action
                ];
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/feed', $data));
    }
    
    public function install() {
        Theme::language('module/feed');
        
        if (!User::hasPermission('modify', 'module/feed')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/feed', '', 'SSL'));
        } else {
            Theme::model('setting/module');

            $feed = Request::p()->get['feed'];
            
            SettingModule::install('feed', $feed);
            
            Theme::model('people/user_group');
            
            PeopleUserGroup::addPermission(User::getId(), 'access', 'feed/' . $feed);
            PeopleUserGroup::addPermission(User::getId(), 'modify', 'feed/' . $feed);
            
            $class = Finder::make('feed' . SEP . $feed);
            
            if (method_exists($class, 'install')) {
                $class->install();
            }
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/feed', '', 'SSL'));
        }
    }
    
    public function uninstall() {
        Theme::language('module/feed');
        
        if (!User::hasPermission('modify', 'module/feed')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/feed', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');

            $feed = Request::p()->get['feed'];
            
            SettingModule::uninstall('feed', $feed);
            SettingSetting::deleteSetting($feed);
            
            $class = Finder::make('feed' . SEP . $feed);
            
            if (method_exists($class, 'uninstall')) {
                $class->uninstall();
            }
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/feed', '', 'SSL'));
        }
    }
}
