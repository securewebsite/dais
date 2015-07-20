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
        if (Customer::isLogged()):
            Response::redirect(Url::link('account/dashboard', '', 'SSL'));
        endif;
        
        if (isset(Request::p()->get['code'])):
            $code = Request::p()->get['code'];
        else:
            $code = '';
        endif;
        
        Theme::model('account/customer');
        $customer_info = AccountCustomer::getCustomerByCode($code);

        if ($customer_info):
            $data = Theme::language('account/reset');
            
            if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
                AccountCustomer::editPassword($customer_info['customer_id'], Request::p()->post['password']);
                Session::p()->data['success'] = Lang::get('lang_text_success');
                Response::redirect(Url::link('account/login', '', 'SSL'));
            endif;
            
            Breadcrumb::add('lang_text_reset', 'account/reset');
            
            if (isset($this->error['warning'])):
                $data['error_warning'] = $this->error['warning'];
            else:
                $data['error_warning'] = '';
            endif;
            
            if (isset(Session::p()->data['success'])):
                $data['success'] = Session::p()->data['success'];
                unset(Session::p()->data['success']);
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
            
            $data['action'] = Url::link('account/reset', 'code=' . $code, 'SSL');
            $data['cancel'] = Url::link('account/login', '', 'SSL');
            
            if (isset(Request::p()->post['password'])):
                $data['password'] = Request::p()->post['password'];
            else:
                $data['password'] = '';
            endif;
            
            if (isset(Request::p()->post['confirm'])):
                $data['confirm'] = Request::p()->post['confirm'];
            else:
                $data['confirm'] = '';
            endif;
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('account/reset', $data));
        else:
             Response::redirect(Url::link('account/login', '', 'SSL'));
        endif;
    }
    
    protected function validate() {
        if ((Encode::strlen(Request::p()->post['password']) < 4) || (Encode::strlen(Request::p()->post['password']) > 20)):
            $this->error['password'] = Lang::get('lang_error_password');
        endif;
        
        if (Request::p()->post['confirm'] != Request::p()->post['password']):
            $this->error['confirm'] = Lang::get('lang_error_confirm');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
