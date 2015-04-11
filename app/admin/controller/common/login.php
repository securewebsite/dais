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

namespace Admin\Controller\Common;
use Dais\Engine\Controller;

class Login extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('common/login');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
            $this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['token'] = md5(mt_rand());
            
            if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->app['http.server']) === 0 || strpos($this->request->post['redirect'], $this->app['https.server']) === 0)) {
                $this->response->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
            } else {
                $this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }
        
        if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
            $this->error['warning'] = $this->language->get('lang_error_token');
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['action'] = $this->url->link('common/login', '', 'SSL');
        
        if (isset($this->request->post['user_name'])) {
            $data['user_name'] = $this->request->post['user_name'];
        } else {
            $data['user_name'] = '';
        }
        
        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
        }
        
        if (isset($this->request->get['route'])) {
            $route = $this->request->get['route'];
            
            unset($this->request->get['route']);
            
            if (isset($this->request->get['token'])) {
                unset($this->request->get['token']);
            }
            
            $url = '';
            
            if ($this->request->get) {
                $url.= http_build_query($this->request->get);
            }
            
            $data['redirect'] = $this->url->link($route, $url, 'SSL');
        } else {
            $data['redirect'] = '';
        }
        
        if ($this->config->get('config_password')) {
            $data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
        } else {
            $data['forgotten'] = '';
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->unset_controller('breadcrumb');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('common/login', $data));
    }
    
    protected function validate() {
        if (!isset($this->request->post['user_name']) || !isset($this->request->post['password']) || !$this->user->login($this->request->post['user_name'], $this->request->post['password'])) {
            $this->error['warning'] = $this->language->get('lang_error_login');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
