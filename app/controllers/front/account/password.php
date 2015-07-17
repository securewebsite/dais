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

class Password extends Controller {
    
    private $error = array();
    
    public function index() {
        if (!Customer::isLogged()) {
            Session::p()->data['redirect'] = Url::link('account/password', '', 'SSL');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/password');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            Theme::model('account/customer');
            
            AccountCustomer::editPassword(Customer::getId(), Request::p()->post['password']);
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('account/dashboard', '', 'SSL'));
        }
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_heading_title', 'account/password', null, true, 'SSL');
        
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
        
        $data['action'] = Url::link('account/password', '', 'SSL');
        
        if (isset(Request::p()->post['password'])) {
            $data['password'] = Request::p()->post['password'];
        } else {
            $data['password'] = '';
        }
        
        if (isset(Request::p()->post['confirm'])) {
            $data['confirm'] = Request::p()->post['confirm'];
        } else {
            $data['confirm'] = '';
        }
        
        $data['back'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/password', $data));
    }
    
    protected function validate() {
        if ((Encode::strlen(Request::p()->post['password']) < 4) || (Encode::strlen(Request::p()->post['password']) > 20)) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (Request::p()->post['confirm'] != Request::p()->post['password']) {
            $this->error['confirm'] = Lang::get('lang_error_confirm');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
