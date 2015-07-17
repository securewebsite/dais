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

class Forgotten extends Controller {
    
    private $error = array();
    
    public function index() {
        if (Customer::isLogged()):
            Response::redirect(Url::link('account/dashboard', '', 'SSL'));
        endif;
        
        $data = Theme::language('account/forgotten');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('account/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $code        = sha1(uniqid(mt_rand(), true));
            $customer_id = AccountCustomer::editCode(Request::p()->post['email'], $code);

            $callback = array(
                'customer_id' => $customer_id,
                'link'        => Url::link('account/reset', 'code=' . $code, 'SSL'),
                'callback'    => array(
                    'class'  => __CLASS__,
                    'method' => 'customer_forgotten_message'
                )
            );
            
            Theme::notify('public_customer_forgotten', $callback);

            Session::p()->data['success'] = Lang::get('lang_text_success');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        endif;
        
        Breadcrumb::add('lang_text_forgotten', 'account/forgotten', null, true, 'SSL');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $data['action'] = Url::link('account/forgotten', '', 'SSL');
        $data['back']   = Url::link('account/login', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/forgotten', $data));
    }
    
    protected function validate() {
        if (!isset(Request::p()->post['email'])):
            $this->error['warning'] = Lang::get('lang_error_email');
        elseif (!AccountCustomer::getTotalCustomersByEmail(Request::p()->post['email'])):
            $this->error['warning'] = Lang::get('lang_error_email');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }

    public function customer_forgotten_message($data, $message) {
        $search  = array('!link!');
        $replace = array();

        foreach($data as $key => $value):
            $replace[] = $value;
        endforeach;

        foreach ($message as $key => $value):
            $message[$key] = str_replace($search, $replace, $value);
        endforeach;

        return $message;
    }
}
