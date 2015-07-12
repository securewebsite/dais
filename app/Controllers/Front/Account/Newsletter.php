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

class Newsletter extends Controller {
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = Url::link('account/newsletter', '', 'SSL');
            
            $this->response->redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/newsletter');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            Theme::model('account/customer');
            
            $this->model_account_customer->editNewsletter($this->request->post['newsletter']);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            $this->response->redirect(Url::link('account/dashboard', '', 'SSL'));
        }
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_text_newsletter', 'account/newsletter', null, true, 'SSL');
        
        $data['action'] = Url::link('account/newsletter', '', 'SSL');
        
        $data['newsletter'] = $this->customer->getNewsletter();
        
        $data['back'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('account/newsletter', $data));
    }
}
