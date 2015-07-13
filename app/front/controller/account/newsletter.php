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

class Newsletter extends Controller {
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/newsletter', '', 'SSL');
            
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $data = $this->theme->language('account/newsletter');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->theme->model('account/customer');
            
            $this->model_account_customer->editNewsletter($this->request->post['newsletter']);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
        }
        
        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        $this->breadcrumb->add('lang_text_newsletter', 'account/newsletter', null, true, 'SSL');
        
        $data['action'] = $this->url->link('account/newsletter', '', 'SSL');
        
        $data['newsletter'] = $this->customer->getNewsletter();
        
        $data['back'] = $this->url->link('account/dashboard', '', 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/newsletter', $data));
    }
}
