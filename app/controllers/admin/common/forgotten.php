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

namespace App\Controllers\Admin\Common;

use App\Controllers\Controller;

class Forgotten extends Controller {
    
    private $error = array();
    
    public function index() {
        if (User::isLogged()):
            Response::redirect(Url::link('common/dashboard', '', 'SSL'));
        endif;
        
        if (!Config::get('config_password')):
            Response::redirect(Url::link('common/login', '', 'SSL'));
        endif;
        
        $data = Theme::language('common/forgotten');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $code    = sha1(uniqid(mt_rand(), true));
            $user_id = $this->model_people_user->editCode($this->request->post['email'], $code);

            $callback = array(
                'user_id'  => $user_id,
                'link'     => Url::link('common/reset', 'code=' . $code, 'SSL'),
                'callback' => array(
                    'class'  => __CLASS__,
                    'method' => 'admin_forgotten_email'
                )
            );

            Theme::notify('admin_forgotten_email', $callback);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            Response::redirect(Url::link('common/login', '', 'SSL'));
        endif;
        
        Breadcrumb::add('lang_text_forgotten', 'common/forgotten');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $data['action'] = Url::link('common/forgotten', '', 'SSL');
        $data['cancel'] = Url::link('common/login', '', 'SSL');
        
        if (isset($this->request->post['email'])):
            $data['email'] = $this->request->post['email'];
        else:
            $data['email'] = '';
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('common/forgotten', $data));
    }
    
    protected function validate() {
        if (!isset($this->request->post['email'])):
            $this->error['warning'] = Lang::get('lang_error_email');
        elseif (!$this->model_people_user->getTotalUsersByEmail($this->request->post['email'])):
            $this->error['warning'] = Lang::get('lang_error_email');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
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
