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

class Total extends Controller {
    
    public function index() {
        $data = Theme::language('module/total');
        Theme::setTitle(Lang::get('lang_heading_total'));
        
        Breadcrumb::add('lang_heading_total', 'module/total');
        
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
        
        $modules = SettingModule::getInstalled('total');
        
        foreach ($modules as $key => $value):
            $class = Finder::find('total' . SEP . $value);
            
            if (!$class):
                SettingModule::uninstall('total', $value);
                unset($modules[$key]);
            endif;
        endforeach;
        
        $data['modules'] = array();
        
        $files = Theme::getFiles('total');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('total/' . $module, $data);
                
                $action = [];
                
                if (!in_array($module, $modules)) {
                    $action[] = [
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/total/install', 'total=' . $module, 'SSL')
                    ];
                } else {
                    $action[] = [
                        'text' => Lang::get('lang_text_edit'), 
                        'href' => Url::link('total/' . $module, '', 'SSL')
                    ];
                    
                    $action[] = [
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/total/uninstall', 'total=' . $module, 'SSL')
                    ];
                }
                
                $data['modules'][] = [
                    'name'       => Lang::get('lang_heading_title'), 
                    'status'     => Config::get($module . '_status') ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled'), 
                    'sort_order' => Config::get($module . '_sort_order'), 
                    'action'     => $action
                ];
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/total', $data));
    }
    
    public function install() {
        Lang::load('module/total');
        
        if (!User::hasPermission('modify', 'module/total')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            
            $total = Request::p()->get['total'];

            SettingModule::install('total', $total);
            
            Theme::model('people/user_group');
            
            PeopleUserGroup::addPermission(User::getId(), 'access', 'total/' . $total);
            PeopleUserGroup::addPermission(User::getId(), 'modify', 'total/' . $total);
            
            $class = Finder::make('total' . SEP . $total);
            
            if (method_exists($class, 'install')):
                $class->install();
            endif;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/total');
        
        if (!User::hasPermission('modify', 'module/total')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');

            $total = Request::p()->get['total'];
            
            SettingModule::uninstall('total', $total);
            SettingSetting::deleteSetting($total);
            
            $class = Finder::make('total', SEP . $total);
            
            if (method_exists($class, 'uninstall')):
                $class->uninstall();
            endif;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/total', '', 'SSL'));
        }
    }
}
