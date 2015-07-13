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
use Dais\Support\Naming;

class Widget extends Controller {
    public function index() {
        $data = Theme::language('module/widget');
        Theme::setTitle(Lang::get('lang_heading_widget'));
        
        Breadcrumb::add('lang_heading_widget', 'module/widget');
        
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
        
        $modules = $this->model_setting_module->getInstalled('widget');
        
        foreach ($modules as $key => $value) {
            $theme_file = Theme::getPath() . 'Controller/Widget/' . ucfirst($value) . '.php';
            $core_file  = Config::get('path.application') . 'Widget/' . ucfirst($value) . '.php';
            
            if (!is_readable($theme_file) && !is_readable($core_file)) {
                $this->model_setting_module->uninstall('widget', $value);
                
                unset($modules[$key]);
            }
        }
        
        $data['modules'] = array();
        
        $files = Theme::getFiles('widget');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('widget/' . $module, $data);
                
                $action = array();
                
                if (!in_array($module, $modules)) {
                    $action[] = array(
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/widget/install', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL')
                    );
                } else {
                    $action[] = array(
                        'text' => Lang::get('lang_text_edit'), 
                        'href' => Url::link('widget/' . $module . '', 'token=' . $this->session->data['token'], 'SSL')
                    );
                    
                    $action[] = array(
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/widget/uninstall', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL')
                    );
                }
                
                $data['modules'][] = array('name' => Lang::get('lang_heading_title'), 'action' => $action);
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('module/widget', $data));
    }
    
    public function install() {
        Lang::load('module/widget');
        
        if (!User::hasPermission('modify', 'module/widget')) {
            $this->session->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            Theme::model('setting/module');
            
            $this->model_setting_module->install('widget', $this->request->get['module']);
            
            Theme::model('people/user_group');
            
            $this->model_people_user_group->addPermission(User::getId(), 'access', 'widget/' . $this->request->get['module']);
            $this->model_people_user_group->addPermission(User::getId(), 'modify', 'widget/' . $this->request->get['module']);
            
            $base_path  = Config::get('path.application') . 'Widget' . SEP;
            $theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'Controller' . SEP . 'Widget' . SEP;
            
            if (is_readable($file = $theme_path . ucfirst($this->request->get['module']) . '.php')):
                $class = Naming::class_from_filename($file);
            else:
                $class = Naming::class_from_filename($base_path . ucfirst($this->request->get['module']) . '.php');
            endif;
            
            $class = new $class;
            
            if (method_exists($class, 'install')) {
                $class->install();
            }
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/widget');
        
        if (!User::hasPermission('modify', 'module/widget')) {
            $this->session->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');
            
            $this->model_setting_module->uninstall('widget', $this->request->get['module']);
            $this->model_setting_setting->deleteSetting($this->request->get['module']);
            
            $base_path  = Config::get('path.application') . 'Widget' . SEP;
            $theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'Controller' . SEP . 'Widget' . SEP;
            
            if (is_readable($file = $theme_path . ucfirst($this->request->get['module']) . '.php')):
                $class = Naming::class_from_filename($file);
            else:
                $class = Naming::class_from_filename($base_path . ucfirst($this->request->get['module']) . '.php');
            endif;
            
            $class = new $class;
            
            if (method_exists($class, 'uninstall')) {
                $class->uninstall();
            }
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
}
