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

class Dashboard extends Controller {
    
    private $error = array();
    
    public function index() {
        if (!Customer::isLogged()) {
            Session::p()->data['redirect'] = Url::link('account/dashboard', '', 'SSL');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/dashboard');
        Theme::model('account/customer');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        if (isset(Session::p()->data['warning'])):
            $data['warning'] = Session::p()->data['warning'];
            unset(Session::p()->data['warning']);
        elseif (isset($this->error['warning'])):
            $data['warning'] = $this->error['warning'];
        else:
            $data['warning'] = '';
        endif;
        
        $data['affiliate'] = false;

        if (Config::get('config_affiliate_allowed') && Customer::isAffiliate()):
            $data['affiliate'] = Url::link('account/affiliate', '', 'SSL');
        endif;

        $data['edit']        = Url::link('account/edit', '', 'SSL');
        $data['password']    = Url::link('account/password', '', 'SSL');
        $data['address']     = Url::link('account/address', '', 'SSL');
        $data['wishlist']    = Url::link('account/wishlist');
        $data['order']       = Url::link('account/order', '', 'SSL');
        $data['return']      = Url::link('account/returns', '', 'SSL');
        $data['credit']      = Url::link('account/credit', '', 'SSL');
        $data['newsletter']  = Url::link('account/newsletter', '', 'SSL');
        $data['recurring']   = Url::link('account/recurring', '', 'SSL');
        $data['waitlist']    = Url::link('account/waitlist', '', 'SSL');
        
        if (Config::get('reward_status')):
            $data['reward'] = Url::link('account/reward', '', 'SSL');
        else:
            $data['reward'] = false;
        endif;
        
        if (Config::get('config_download')):
            $data['download'] = Url::link('account/download', '', 'SSL');
        else:
            $data['download'] = false;
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('account/dashboard', $data));
    }
}
