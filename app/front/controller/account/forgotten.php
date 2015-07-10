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

class Forgotten extends Controller {
    private $error = array();
    
    public function index() {
        if ($this->customer->isLogged()):
            $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
        endif;
        
        $data = $this->theme->language('account/forgotten');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('account/customer');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $code        = sha1(uniqid(mt_rand(), true));
            $customer_id = $this->model_account_customer->editCode($this->request->post['email'], $code);

            $callback = array(
                'customer_id' => $customer_id,
                'link'        => $this->url->link('account/reset', 'code=' . $code, 'SSL'),
                'callback'    => array(
                    'class'  => __CLASS__,
                    'method' => 'customer_forgotten_message'
                )
            );
            
            $this->theme->notify('public_customer_forgotten', $callback);

            $this->session->data['success'] = $this->language->get('lang_text_success');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;
        
        $this->breadcrumb->add('lang_text_forgotten', 'account/forgotten', null, true, 'SSL');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $data['action'] = $this->url->link('account/forgotten', '', 'SSL');
        $data['back']   = $this->url->link('account/login', '', 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/forgotten', $data));
    }
    
    protected function validate() {
        if (!isset($this->request->post['email'])):
            $this->error['warning'] = $this->language->get('lang_error_email');
        elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])):
            $this->error['warning'] = $this->language->get('lang_error_email');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
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
