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

namespace Admin\Controller\Common;
use Dais\Engine\Controller;

class Forgotten extends Controller {
    private $error = array();
    
    public function index() {
        if ($this->user->isLogged()):
            $this->response->redirect($this->url->link('common/dashboard', '', 'SSL'));
        endif;
        
        if (!$this->config->get('config_password')):
            $this->response->redirect($this->url->link('common/login', '', 'SSL'));
        endif;
        
        $data = $this->theme->language('common/forgotten');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $code    = sha1(uniqid(mt_rand(), true));
            $user_id = $this->model_people_user->editCode($this->request->post['email'], $code);

            $callback = array(
                'user_id'  => $user_id,
                'link'     => $this->url->link('common/reset', 'code=' . $code, 'SSL'),
                'callback' => array(
                    'class'  => __CLASS__,
                    'method' => 'admin_forgotten_email'
                )
            );

            $this->theme->notify('admin_forgotten_email', $callback);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            $this->response->redirect($this->url->link('common/login', '', 'SSL'));
        endif;
        
        $this->breadcrumb->add('lang_text_forgotten', 'common/forgotten');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $data['action'] = $this->url->link('common/forgotten', '', 'SSL');
        $data['cancel'] = $this->url->link('common/login', '', 'SSL');
        
        if (isset($this->request->post['email'])):
            $data['email'] = $this->request->post['email'];
        else:
            $data['email'] = '';
        endif;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('common/forgotten', $data));
    }
    
    protected function validate() {
        if (!isset($this->request->post['email'])):
            $this->error['warning'] = $this->language->get('lang_error_email');
        elseif (!$this->model_people_user->getTotalUsersByEmail($this->request->post['email'])):
            $this->error['warning'] = $this->language->get('lang_error_email');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }

    public function admin_forgotten_email($data, $message) {
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
