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

namespace App\Controllers\Front\Content;

use App\Controllers\Controller;

class Contact extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('content/contact');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        JS::register('validation/validate.min', 'migrate.min')
            ->register('validation/validate.bootstrap.min', 'validate.min');

        Breadcrumb::add('lang_heading_title', 'content/contact');
        
        $data['action']    = Url::link('content/contact');
        $data['store']     = Config::get('config_name');
        $data['address']   = nl2br(Config::get('config_address'));
        $data['telephone'] = Config::get('config_telephone');
        
        if (Customer::isLogged()):
            $data['name'] = Customer::getFirstName() . ' ' . Customer::getLastName();
        else:
            $data['name'] = '';
        endif;
        
       
        if (Customer::isLogged()):
            $data['email'] = Customer::getEmail();
        else:
            $data['email'] = '';
        endif;
        
        $data['enquiry'] = '';
        $data['captcha'] = '';
       
        Theme::loadjs('javascript/content/contact', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('content/contact', $data));
    }
    
    public function send() {
        Theme::language('content/contact');
        
        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST'):
            unset($this->session->data['captcha']);
            $json['success'] = Lang::get('lang_text_message');

            $callback = array(
                'user_id'  => Config::get('config_admin_email_user'),
                'post'     => $this->request->post,
                'callback' => array(
                    'class'  => __CLASS__,
                    'method' => 'public_contact_admin'
                )
            );

            Theme::notify('public_contact_admin', $callback);

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
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
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
