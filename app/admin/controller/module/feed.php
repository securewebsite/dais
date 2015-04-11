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

class Feed extends Controller {
    public function index() {
        $data = $this->theme->language('module/feed');
        $this->theme->setTitle($this->language->get('lang_heading_feed'));
        
        $this->breadcrumb->add('lang_heading_feed', 'module/feed');
        
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
        
        $this->theme->model('setting/module');
        
        $modules = $this->model_setting_module->getInstalled('feed');
        
        foreach ($modules as $key => $value) {
            $theme_file = $this->theme->path . 'controller/feed/' . $value . '.php';
            $core_file = $this->app['path.application'] . 'controller/feed/' . $value . '.php';
            
            if (!is_readable($theme_file) && !is_readable($core_file)) {
                $this->model_setting_module->uninstall('feed', $value);
                
                unset($modules[$key]);
            }
        }
        
        $data['modules'] = array();
        
        $files = $this->theme->getFiles('feed');
        
        if ($files) {
            foreach ($files as $file) {
                $module = strtolower(basename($file, '.php'));
                
                $data = $this->theme->language('feed/' . $module, $data);
                
                $action = array();
                
                if (!in_array($module, $modules)) {
                    $action[] = array('text' => $this->language->get('lang_text_install'), 'href' => $this->url->link('module/feed/install', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL'));
                } else {
                    $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('feed/' . $module . '', 'token=' . $this->session->data['token'], 'SSL'));
                    
                    $action[] = array('text' => $this->language->get('lang_text_uninstall'), 'href' => $this->url->link('module/feed/uninstall', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL'));
                }
                
                $data['modules'][] = array('name' => $this->language->get('lang_heading_title'), 'status' => $this->config->get($module . '_status') ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled'), 'action' => $action);
            }
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('module/feed', $data));
    }
    
    public function install() {
        $this->theme->language('module/feed');
        
        if (!$this->user->hasPermission('modify', 'module/feed')) {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->theme->model('setting/module');
            
            $this->model_setting_module->install('feed', $this->request->get['module']);
            
            $this->theme->model('people/user_group');
            
            $this->model_people_user_group->addPermission($this->user->getId(), 'access', 'feed/' . $this->request->get['module']);
            $this->model_people_user_group->addPermission($this->user->getId(), 'modify', 'feed/' . $this->request->get['module']);
            
            if (is_readable($this->theme->path . 'controller/feed/' . $this->request->get['module'] . '.php')):
                $class = 'Theme\Admin\\' . $this->theme->name . '\Controller\Feed\\' . ucfirst($this->request->get['module']);
            else:
                $class = 'Admin\Controller\Feed\\' . ucfirst($this->request->get['module']);
            endif;
            
            $class = new $class($this->app);
            
            if (method_exists($class, 'install')) {
                $class->install();
            }
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
    
    public function uninstall() {
        $this->theme->language('module/feed');
        
        if (!$this->user->hasPermission('modify', 'module/feed')) {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->theme->model('setting/module');
            $this->theme->model('setting/setting');
            
            $this->model_setting_module->uninstall('feed', $this->request->get['module']);
            $this->model_setting_setting->deleteSetting($this->request->get['module']);
            
            if (is_readable($this->theme->path . 'controller/feed/' . $this->request->get['module'] . '.php')):
                $class = 'Theme\Admin\\' . $this->theme->name . '\Controller\Feed\\' . ucfirst($this->request->get['module']);
            else:
                $class = 'Admin\Controller\Feed\\' . ucfirst($this->request->get['module']);
            endif;
            
            $class = new $class($this->app);
            
            if (method_exists($class, 'uninstall')) {
                $class->uninstall();
            }
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
}
