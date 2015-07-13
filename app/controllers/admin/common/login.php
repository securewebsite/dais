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

namespace App\Controllers\Admin\Common;
use App\Controllers\Controller;

class Login extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('common/login');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (User::isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
            Response::redirect(Url::link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['token'] = md5(mt_rand());
            
            if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], Config::get('http.server')) === 0 || strpos($this->request->post['redirect'], Config::get('https.server')) === 0)) {
                Response::redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
            } else {
                Response::redirect(Url::link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }
        
        if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
            $this->error['warning'] = Lang::get('lang_error_token');
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
        
        $data['action'] = Url::link('common/login', '', 'SSL');
        
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
            
            $data['redirect'] = Url::link($route, $url, 'SSL');
        } else {
            $data['redirect'] = '';
        }
        
        if (Config::get('config_password')) {
            $data['forgotten'] = Url::link('common/forgotten', '', 'SSL');
        } else {
            $data['forgotten'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::unset_controller('breadcrumb');
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('common/login', $data));
    }
    
    protected function validate() {
        if (!isset($this->request->post['user_name']) || !isset($this->request->post['password']) || !User::login($this->request->post['user_name'], $this->request->post['password'])) {
            $this->error['warning'] = Lang::get('lang_error_login');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
