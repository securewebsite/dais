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

class Edit extends Controller {
    
    private $error = array();
    
    public function index() {
        if (!Customer::isLogged()) {
            Session::p()->data['redirect'] = Url::link('account/edit', '', 'SSL');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/edit');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('account/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            AccountCustomer::editCustomer(Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            Response::redirect(Url::link('account/dashboard', '', 'SSL'));
        }
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_text_edit', 'account/edit', null, true, 'SSL');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['firstname'])) {
            $data['error_firstname'] = $this->error['firstname'];
        } else {
            $data['error_firstname'] = '';
        }
        
        if (isset($this->error['lastname'])) {
            $data['error_lastname'] = $this->error['lastname'];
        } else {
            $data['error_lastname'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }
        
        if (isset($this->error['telephone'])) {
            $data['error_telephone'] = $this->error['telephone'];
        } else {
            $data['error_telephone'] = '';
        }
        
        $data['action'] = Url::link('account/edit', '', 'SSL');
        
        if (Request::p()->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = AccountCustomer::getCustomer(Customer::getId());
        }
        
        if (isset($customer_info)):
            $data['username'] = $customer_info['username'];
        else:
            $data['username'] = '';
        endif;
        
        if (isset(Request::p()->post['firstname'])) {
            $data['firstname'] = Request::p()->post['firstname'];
        } elseif (isset($customer_info)) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }
        
        if (isset(Request::p()->post['lastname'])) {
            $data['lastname'] = Request::p()->post['lastname'];
        } elseif (isset($customer_info)) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset(Request::p()->post['email'])) {
            $data['email'] = Request::p()->post['email'];
        } elseif (isset($customer_info)) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset(Request::p()->post['telephone'])) {
            $data['telephone'] = Request::p()->post['telephone'];
        } elseif (isset($customer_info)) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }
        
        $data['back'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/edit', $data));
    }
    
    protected function validate() {
        if ((Encode::strlen(Request::p()->post['firstname']) < 1) || (Encode::strlen(Request::p()->post['firstname']) > 32)) {
            $this->error['firstname'] = Lang::get('lang_error_firstname');
        }
        
        if ((Encode::strlen(Request::p()->post['lastname']) < 1) || (Encode::strlen(Request::p()->post['lastname']) > 32)) {
            $this->error['lastname'] = Lang::get('lang_error_lastname');
        }
        
        if ((Encode::strlen(Request::p()->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', Request::p()->post['email'])) {
            $this->error['email'] = Lang::get('lang_error_email');
        }
        
        if ((Customer::getEmail() != Request::p()->post['email']) && AccountCustomer::getTotalCustomersByEmail(Request::p()->post['email'])) {
            $this->error['warning'] = Lang::get('lang_error_exists');
        }
        
        if ((Encode::strlen(Request::p()->post['telephone']) < 3) || (Encode::strlen(Request::p()->post['telephone']) > 32)) {
            $this->error['telephone'] = Lang::get('lang_error_telephone');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
