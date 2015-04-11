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

namespace Front\Controller\Account;
use Dais\Engine\Controller;

class Password extends Controller {
    private $error = array();
    
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/password', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $data = $this->theme->language('account/password');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->theme->model('account/customer');
            
            $this->model_account_customer->editPassword($this->customer->getId(), $this->request->post['password']);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
        }
        
        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        $this->breadcrumb->add('lang_heading_title', 'account/password', null, true, 'SSL');
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['confirm'])) {
            $data['error_confirm'] = $this->error['confirm'];
        } else {
            $data['error_confirm'] = '';
        }
        
        $data['action'] = $this->url->link('account/password', '', 'SSL');
        
        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
        }
        
        if (isset($this->request->post['confirm'])) {
            $data['confirm'] = $this->request->post['confirm'];
        } else {
            $data['confirm'] = '';
        }
        
        $data['back'] = $this->url->link('account/dashboard', '', 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/password', $data));
    }
    
    protected function validate() {
        if (($this->encode->strlen($this->request->post['password']) < 4) || ($this->encode->strlen($this->request->post['password']) > 20)) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if ($this->request->post['confirm'] != $this->request->post['password']) {
            $this->error['confirm'] = $this->language->get('lang_error_confirm');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
