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

namespace App\Controllers\Front\Account;
use App\Controllers\Controller;

class Reset extends Controller {
    private $error = array();
    
    public function index() {
        if ($this->customer->isLogged()):
            $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
        endif;
        
        if (isset($this->request->get['code'])):
            $code = $this->request->get['code'];
        else:
            $code = '';
        endif;
        
        $this->theme->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomerByCode($code);

        if ($customer_info):
            $data = $this->theme->language('account/reset');
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
                $this->model_account_customer->editPassword($customer_info['customer_id'], $this->request->post['password']);
                $this->session->data['success'] = $this->language->get('lang_text_success');
                $this->response->redirect($this->url->link('account/login', '', 'SSL'));
            endif;
            
            $this->breadcrumb->add('lang_text_reset', 'account/reset');
            
            if (isset($this->error['warning'])):
                $data['error_warning'] = $this->error['warning'];
            else:
                $data['error_warning'] = '';
            endif;
            
            if (isset($this->session->data['success'])):
                $data['success'] = $this->session->data['success'];
                unset($this->session->data['success']);
            else:
                $data['success'] = '';
            endif;
            
            if (isset($this->error['password'])):
                $data['error_password'] = $this->error['password'];
            else:
                $data['error_password'] = '';
            endif;
            
            if (isset($this->error['confirm'])):
                $data['error_confirm'] = $this->error['confirm'];
            else:
                $data['error_confirm'] = '';
            endif;
            
            $data['action'] = $this->url->link('account/reset', 'code=' . $code, 'SSL');
            $data['cancel'] = $this->url->link('account/login', '', 'SSL');
            
            if (isset($this->request->post['password'])):
                $data['password'] = $this->request->post['password'];
            else:
                $data['password'] = '';
            endif;
            
            if (isset($this->request->post['confirm'])):
                $data['confirm'] = $this->request->post['confirm'];
            else:
                $data['confirm'] = '';
            endif;
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            $data = $this->theme->renderControllers($data);
            
            $this->response->setOutput($this->theme->view('account/reset', $data));
        else:
             $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;
    }
    
    protected function validate() {
        if (($this->encode->strlen($this->request->post['password']) < 4) || ($this->encode->strlen($this->request->post['password']) > 20)):
            $this->error['password'] = $this->language->get('lang_error_password');
        endif;
        
        if ($this->request->post['confirm'] != $this->request->post['password']):
            $this->error['confirm'] = $this->language->get('lang_error_confirm');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
