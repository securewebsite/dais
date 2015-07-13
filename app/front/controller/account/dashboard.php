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
use Dais\Base\Controller;

class Dashboard extends Controller {
    private $error = array();
    
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/dashboard', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $data = $this->theme->language('account/dashboard');
        $this->theme->model('account/customer');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        if (isset($this->session->data['warning'])):
            $data['warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        elseif (isset($this->error['warning'])):
            $data['warning'] = $this->error['warning'];
        else:
            $data['warning'] = '';
        endif;
        
        $data['affiliate'] = false;

        if ($this->config->get('config_affiliate_allowed') && $this->customer->isAffiliate()):
            $data['affiliate'] = $this->url->link('account/affiliate', '', 'SSL');
        endif;

        $data['edit']        = $this->url->link('account/edit', '', 'SSL');
        $data['password']    = $this->url->link('account/password', '', 'SSL');
        $data['address']     = $this->url->link('account/address', '', 'SSL');
        $data['wishlist']    = $this->url->link('account/wishlist');
        $data['order']       = $this->url->link('account/order', '', 'SSL');
        $data['return']      = $this->url->link('account/returns', '', 'SSL');
        $data['credit']      = $this->url->link('account/credit', '', 'SSL');
        $data['newsletter']  = $this->url->link('account/newsletter', '', 'SSL');
        $data['recurring']   = $this->url->link('account/recurring', '', 'SSL');
        $data['waitlist']    = $this->url->link('account/waitlist', '', 'SSL');
        
        if ($this->config->get('reward_status')):
            $data['reward'] = $this->url->link('account/reward', '', 'SSL');
        else:
            $data['reward'] = false;
        endif;
        
        if ($this->config->get('config_download')):
            $data['download'] = $this->url->link('account/download', '', 'SSL');
        else:
            $data['download'] = false;
        endif;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/dashboard', $data));
    }
}
