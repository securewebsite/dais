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

class Shipping extends Controller {
    
    public function index() {
        $data = Theme::language('module/shipping');
        Theme::setTitle(Lang::get('lang_heading_shipping'));
        
        Breadcrumb::add('lang_heading_shipping', 'module/shipping');
        
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
        
        $modules = SettingModule::getInstalled('shipping');
        
        foreach ($modules as $key => $value):
            $class = Finder::find('shipping' . SEP . $value);
            
            if (!$class):
                SettingModule::uninstall('shipping', $value);
                unset($modules[$key]);
            endif;
        endforeach;
        
        $data['modules'] = array();
        
        $files = Theme::getFiles('shipping');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('shipping/' . $module, $data);
                
                $action = [];
                
                if (!in_array($module, $modules)) {
                    $action[] = [
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/shipping/install', 'shipping=' . $module, 'SSL')
                    ];
                } else {
                    $action[] = [
                        'text' => Lang::get('lang_text_edit'), 
                        'href' => Url::link('shipping/' . $module, '', 'SSL')
                    ];
                    
                    $action[] = [
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/shipping/uninstall', 'shipping=' . $module, 'SSL')
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
        
        Response::setOutput(View::make('module/shipping', $data));
    }
    
    public function install() {
        Lang::load('module/shipping');
        
        if (!User::hasPermission('modify', 'module/shipping')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        } else {
            Theme::model('setting/module');

            $shipping = Request::p()->get['shipping'];
            
            SettingModule::install('shipping', $shipping);
            
            Theme::model('people/user_group');
            
            PeopleUserGroup::addPermission(User::getId(), 'access', 'shipping/' . $shipping);
            PeopleUserGroup::addPermission(User::getId(), 'modify', 'shipping/' . $shipping);
            
            $class = Finder::make('shipping' . SEP . $shipping);
            
            if (method_exists($class, 'install')):
                $class->install();
            endif;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/shipping');
        
        if (!User::hasPermission('modify', 'module/shipping')) {
            Session::p()->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');

            $shipping = Request::p()->get['shipping'];
            
            SettingModule::uninstall('shipping', $shipping);
            SettingSetting::deleteSetting($shipping);
            
            $class = Finder::make('shipping' . SEP . $shipping);
            
            if (method_exists($class, 'uninstall')):
                $class->uninstall();
            endif;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
    }
}
