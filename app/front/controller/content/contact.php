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

namespace Front\Controller\Content;
use Dais\Engine\Controller;

class Contact extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('content/contact');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->javascript->register('validation/validate.min', 'migrate.min')
            ->register('validation/validate.bootstrap.min', 'validate.min');

        $this->breadcrumb->add('lang_heading_title', 'content/contact');
        
        $data['action']    = $this->url->link('content/contact');
        $data['store']     = $this->config->get('config_name');
        $data['address']   = nl2br($this->config->get('config_address'));
        $data['telephone'] = $this->config->get('config_telephone');
        
        if ($this->customer->isLogged()):
            $data['name'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
        else:
            $data['name'] = '';
        endif;
        
       
        if ($this->customer->isLogged()):
            $data['email'] = $this->customer->getEmail();
        else:
            $data['email'] = '';
        endif;
        
        $data['enquiry'] = '';
        $data['captcha'] = '';
       
        $this->theme->loadjs('javascript/content/contact', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/contact', $data));
    }
    
    public function send() {
        $this->theme->language('content/contact');
        
        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST'):
            unset($this->session->data['captcha']);
            $json['success'] = $this->language->get('lang_text_message');

            $callback = array(
                'user_id'  => $this->config->get('config_admin_email_user'),
                'post'     => $this->request->post,
                'callback' => array(
                    'class'  => __CLASS__,
                    'method' => 'public_contact_admin'
                )
            );

            $this->theme->notify('public_contact_admin', $callback);

            unset($callback);

            /**
             * Build our customer contact notification
             */
            
            $split    = explode(' ', $this->request->post['name']);
            $callback = array(
                'firstname' => $split[0],
                'lastname'  => isset($split[1]) ? $split[1] : '',
                'email'     => $this->request->post['email']
            );

            $this->notify->setGenericCustomer($callback);

            $message  = $this->notify->fetch('public_contact_customer');
            $priority = $message['priority'];

            $this->notify->fetchWrapper($priority);

            $message = $this->notify->formatEmail($message, 1);

            if ($priority == 1):
                $this->notify->send($message);
            else:
                $this->notify->addToEmailQueue($message);
            endif;

        else:
            $json['error'] = $this->error['captcha'];
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function captcha() {
        echo $this->session->data['captcha'];
    }

    public function public_contact_admin($data, $message) {
        $call = $data['post'];

        $search = array(
            '!name!',
            '!email!',
            '!inquiry!'
        );

        $replace = array(
            $call['name'],
            $call['email'],
            $call['enquiry']
        );

        $html_replace = array(
            $call['name'],
            $call['email'],
            nl2br($call['enquiry'])
        );

        foreach ($message as $key => $value):
            if ($key == 'html'):
                $message['html'] = str_replace($search, $html_replace, $message['html']);
            else:
                $message[$key] = str_replace($search, $replace, $message[$key]);
            endif;
        endforeach;

        return $message;
    }
}
