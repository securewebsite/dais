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

class Success extends Controller {
    
    public function index() {
        $data = Theme::language('account/success');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('account/customer_group');
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_text_success', 'account/success', null, true, 'SSL');
        
        $customer_group = AccountCustomerGroup::getCustomerGroup(Customer::getGroupId());
        
        if ($customer_group && !$customer_group['approval']) {
            $data['text_message'] = sprintf(Lang::get('lang_text_message'), Url::link('content/contact'));
        } else {
            $data['text_message'] = sprintf(Lang::get('lang_text_approval'), Config::get('config_name'), Url::link('content/contact'));
        }
        
        if (Cart::hasProducts()) {
            $data['continue'] = Url::link('checkout/cart', '', 'SSL');
        } else {
            $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('common/success', $data));
    }
}
