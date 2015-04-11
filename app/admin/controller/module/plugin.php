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

class Plugin extends Controller {
    public function index() {
        $data = $this->theme->language('module/plugin');
        $this->theme->setTitle($this->language->get('lang_heading_plugin'));
        
        $this->breadcrumb->add('lang_heading_plugin', 'module/plugin');
        
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
        
        $modules = $this->model_setting_module->getInstalled('plugin');
        
        foreach ($modules as $key => $value) {
            $file = $this->app['path.plugin'] . $value . '/register.php';
            
            if (!is_readable($file)) {
                $this->model_setting_module->uninstall('plugin', $value);
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
                    $action[] = array('text' => $this->language->get('lang_text_install'), 'href' => $this->url->link('module/plugin/install', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL'));
                } else {
                    if (is_readable($this->app['path.plugin'] . $module . '/admin/controller/' . $module . '.php')):
                        $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('plugin/' . $module . '', 'token=' . $this->session->data['token'], 'SSL'));
                    endif;
                    
                    $action[] = array('text' => $this->language->get('lang_text_uninstall'), 'href' => $this->url->link('module/plugin/uninstall', 'token=' . $this->session->data['token'] . '&module=' . $module, 'SSL'));
                }
                
                $data['modules'][] = array('name' => $this->language->get('lang_heading_title'), 'action' => $action);
            }
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('module/plugin', $data));
    }
    
    public function install() {
        $this->language->load('module/plugin');
        
        if (!$this->user->hasPermission('modify', 'module/plugin')) {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->theme->model('setting/module');
            
            $this->model_setting_module->install('plugin', $this->request->get['module']);
            
            if (is_readable($this->app['path.plugin'] . $this->request->get['module'] . '/controller/' . $this->request->get['module'] . '.php')):
                $this->theme->model('people/user_group');
                
                $this->model_people_user_group->addPermission($this->user->getId(), 'access', 'plugin/' . $this->request->get['module']);
                $this->model_people_user_group->addPermission($this->user->getId(), 'modify', 'plugin/' . $this->request->get['module']);
            endif;
            
            $this->plugin->install($this->request->get['module']);
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
    
    public function uninstall() {
        $this->language->load('module/plugin');
        
        if (!$this->user->hasPermission('modify', 'module/plugin')) {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->theme->model('setting/module');
            $this->theme->model('setting/setting');
            
            $this->model_setting_module->uninstall('plugin', $this->request->get['module']);
            $this->model_setting_setting->deleteSetting($this->request->get['module']);
            
            $this->plugin->uninstall($this->request->get['module']);
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
}
