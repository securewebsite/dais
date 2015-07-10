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

namespace Front\Controller\Widget;
use Dais\Base\Controller;

class Account extends Controller {
    public function index() {
        $data = $this->theme->language('widget/account');
        $this->theme->model('tool/utility');
        
        $data['logged']       = $this->customer->isLogged();
        $data['register']     = $this->url->link('account/register', '', 'SSL');
        $data['login']        = $this->url->link('account/login', '', 'SSL');
        $data['logout']       = $this->url->link('account/logout', '', 'SSL');
        $data['forgotten']    = $this->url->link('account/forgotten', '', 'SSL');
        $data['account']      = $this->url->link('account/dashboard', '', 'SSL');
        $data['edit']         = $this->url->link('account/edit', '', 'SSL');
        $data['password']     = $this->url->link('account/password', '', 'SSL');
        $data['address']      = $this->url->link('account/address', '', 'SSL');
        $data['wishlist']     = $this->url->link('account/wishlist');
        $data['order']        = $this->url->link('account/order', '', 'SSL');
        $data['download']     = ($this->config->get('config_download')) ? $this->url->link('account/download', '', 'SSL') : false;
        $data['reward']       = ($this->config->get('reward_status')) ? $this->url->link('account/reward', '', 'SSL') : false;
        $data['product']      = (!empty($this->customer->getCustomerProducts())) ? $this->url->link('account/product', '', 'SSL') : false;
        $data['affiliate']    = ($this->config->get('config_affiliate_allowed')) ? $this->url->link('account/affiliate', '', 'SSL') : false;
        $data['return']       = $this->url->link('account/returns', '', 'SSL');
        $data['credit']       = $this->url->link('account/credit', '', 'SSL');
        $data['newsletter']   = $this->url->link('account/newsletter', '', 'SSL');
        $data['recurring']    = $this->url->link('account/recurring', '', 'SSL');
        $data['notification'] = $this->url->link('account/notification', '', 'SSL');
        $data['unread']       = $this->model_tool_utility->getUnreadCustomerNotifications($this->customer->getId());
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/account', $data);
    }
}
