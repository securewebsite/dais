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

namespace App\Controllers\Front\Widget;

use App\Controllers\Controller;

class Account extends Controller {
    
    public function index() {
        $data = Theme::language('widget/account');
        Theme::model('tool/utility');
        
        $data['logged']       = Customer::isLogged();
        $data['register']     = Url::link('account/register', '', 'SSL');
        $data['login']        = Url::link('account/login', '', 'SSL');
        $data['logout']       = Url::link('account/logout', '', 'SSL');
        $data['forgotten']    = Url::link('account/forgotten', '', 'SSL');
        $data['account']      = Url::link('account/dashboard', '', 'SSL');
        $data['edit']         = Url::link('account/edit', '', 'SSL');
        $data['password']     = Url::link('account/password', '', 'SSL');
        $data['address']      = Url::link('account/address', '', 'SSL');
        $data['wishlist']     = Url::link('account/wishlist');
        $data['order']        = Url::link('account/order', '', 'SSL');
        $data['download']     = (Config::get('config_download')) ? Url::link('account/download', '', 'SSL') : false;
        $data['reward']       = (Config::get('reward_status')) ? Url::link('account/reward', '', 'SSL') : false;
        $data['product']      = (!empty(Customer::getCustomerProducts())) ? Url::link('account/product', '', 'SSL') : false;
        $data['affiliate']    = (Config::get('config_affiliate_allowed')) ? Url::link('account/affiliate', '', 'SSL') : false;
        $data['return']       = Url::link('account/returns', '', 'SSL');
        $data['credit']       = Url::link('account/credit', '', 'SSL');
        $data['newsletter']   = Url::link('account/newsletter', '', 'SSL');
        $data['recurring']    = Url::link('account/recurring', '', 'SSL');
        $data['notification'] = Url::link('account/notification', '', 'SSL');
        $data['unread']       = ToolUtility::getUnreadCustomerNotifications(Customer::getId());
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('widget/account', $data);
    }
}
