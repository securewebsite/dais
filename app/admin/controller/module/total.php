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

namespace Admin\Controller\Module;
use Dais\Engine\Controller;
use Dais\Library\Naming;

class Total extends Controller {
    public function index() {
        $data = Theme::language('module/total');
        Theme::setTitle($this->language->get('lang_heading_total'));
        
        $this->breadcrumb->add('lang_heading_total', 'module/total');
        
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
        
        $modules = $this->model_setting_module->getInstalled('total');
        
        foreach ($modules as $key => $value) {
            $theme_file = Theme::path . 'controller/total/' . $value . '.php';
            $core_file = Config::get('path.application') . 'controller/total/' . $value . '.php';
            
            if (!is_readable($theme_file) && !is_readable($core_file)) {
                $this->model_setting_module->uninstall('total', $value);
                
                unset($modules[$key]);
            }
        }
        
        $data['modules'] = array();
        
        $files = Theme::getFiles('total');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('total/' . $module, $data);
                
                $action = array();
                
                if (!in_array($module, $modules)) {
                    $action[] = array('text' => $this->language->get('lang_text_install'), 'href' => $this->url->link('module/total/install', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL'));
                } else {
                    $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('total/' . $module . '', 'token=' . $this->session->data['token'], 'SSL'));
                    
                    $action[] = array('text' => $this->language->get('lang_text_uninstall'), 'href' => $this->url->link('module/total/uninstall', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL'));
                }
                
                $data['modules'][] = array('name' => $this->language->get('lang_heading_title'), 'status' => Config::get($module . '_status') ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled'), 'sort_order' => Config::get($module . '_sort_order'), 'action' => $action);
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('module/total', $data));
    }
    
    public function install() {
        $this->language->load('module/total');
        
        if (!User::hasPermission('modify', 'module/total')) {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            Theme::model('setting/module');
            
            $this->model_setting_module->install('total', $this->request->get['module']);
            
            Theme::model('people/user_group');
            
            $this->model_people_user_group->addPermission(User::getId(), 'access', 'total/' . $this->request->get['module']);
            $this->model_people_user_group->addPermission(User::getId(), 'modify', 'total/' . $this->request->get['module']);
            
            $base_path  = APP_PATH . Config::get('prefix.facade') . 'controller' . SEP . 'total' . SEP;
            $theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'controller' . SEP . 'total' . SEP;
            
            if (is_readable($file = $theme_path . $this->request->get['module'] . '.php')):
                $class = Naming::class_from_filename($file);
            else:
                $class = Naming::class_from_filename($base_path . $this->request->get['module'] . '.php');
            endif;
            
            $class = new $class;
            
            if (method_exists($class, 'install')) {
                $class->install();
            }
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
    
    public function uninstall() {
        $this->language->load('module/total');
        
        if (!User::hasPermission('modify', 'module/total')) {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');
            
            $this->model_setting_module->uninstall('total', $this->request->get['module']);
            $this->model_setting_setting->deleteSetting($this->request->get['module']);
            
            $base_path  = APP_PATH . Config::get('prefix.facade') . 'controller' . SEP . 'total' . SEP;
            $theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'controller' . SEP . 'total' . SEP;
            
            if (is_readable($file = $theme_path . $this->request->get['module'] . '.php')):
                $class = Naming::class_from_filename($file);
            else:
                $class = Naming::class_from_filename($base_path . $this->request->get['module'] . '.php');
            endif;
            
            $class = new $class;
            
            if (method_exists($class, 'uninstall')) {
                $class->uninstall();
            }
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect($this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
}
