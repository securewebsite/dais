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
use Dais\Base\Controller;
use Dais\Library\Naming;

class Shipping extends Controller {
    public function index() {
        $data = Theme::language('module/shipping');
        Theme::setTitle(Lang::get('lang_heading_shipping'));
        
        Breadcrumb::add('lang_heading_shipping', 'module/shipping');
        
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
        
        $modules = $this->model_setting_module->getInstalled('shipping');
        
        foreach ($modules as $key => $value) {
            $theme_file = Theme::path . 'controller/shipping/' . $value . '.php';
            $core_file = Config::get('path.application') . 'controller/shipping/' . $value . '.php';
            
            if (!is_readable($theme_file) && !is_readable($core_file)) {
                $this->model_setting_module->uninstall('shipping', $value);
                
                unset($modules[$key]);
            }
        }
        
        $data['modules'] = array();
        
        $files = Theme::getFiles('shipping');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = Theme::language('shipping/' . $module, $data);
                
                $action = array();
                
                if (!in_array($module, $modules)) {
                    $action[] = array(
                        'text' => Lang::get('lang_text_install'), 
                        'href' => Url::link('module/shipping/install', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL')
                    );
                } else {
                    $action[] = array(
                        'text' => Lang::get('lang_text_edit'), 
                        'href' => Url::link('shipping/' . $module . '', 'token=' . $this->session->data['token'], 'SSL')
                    );
                    
                    $action[] = array(
                        'text' => Lang::get('lang_text_uninstall'), 
                        'href' => Url::link('module/shipping/uninstall', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL')
                    );
                }
                
                $data['modules'][] = array(
                    'name'       => Lang::get('lang_heading_title'), 
                    'status'     => Config::get($module . '_status') ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled'), 
                    'sort_order' => Config::get($module . '_sort_order'), 
                    'action'     => $action
                );
            }
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('module/shipping', $data));
    }
    
    public function install() {
        Lang::load('module/shipping');
        
        if (!User::hasPermission('modify', 'module/shipping')) {
            $this->session->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            Theme::model('setting/module');
            
            $this->model_setting_module->install('shipping', $this->request->get['module']);
            
            Theme::model('people/user_group');
            
            $this->model_people_user_group->addPermission(User::getId(), 'access', 'shipping/' . $this->request->get['module']);
            $this->model_people_user_group->addPermission(User::getId(), 'modify', 'shipping/' . $this->request->get['module']);
            
            $base_path  = APP_PATH . Config::get('prefix.facade') . 'controller' . SEP . 'shipping' . SEP;
            $theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'controller' . SEP . 'shipping' . SEP;
            
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
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
    
    public function uninstall() {
        Lang::load('module/shipping');
        
        if (!User::hasPermission('modify', 'module/shipping')) {
            $this->session->data['error'] = Lang::get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            Theme::model('setting/module');
            Theme::model('setting/setting');
            
            $this->model_setting_module->uninstall('shipping', $this->request->get['module']);
            $this->model_setting_setting->deleteSetting($this->request->get['module']);
            
            $base_path  = APP_PATH . Config::get('prefix.facade') . 'controller' . SEP . 'shipping' . SEP;
            $theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'controller' . SEP . 'shipping' . SEP;
            
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
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
}
