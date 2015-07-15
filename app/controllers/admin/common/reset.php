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
use Dais\Base\Action;

class Reset extends Controller {
    private $error = array();
    
    public function index() {
        if (User::isLogged()):
            Response::redirect(Url::link('common/dashboard', '', 'SSL'));
        endif;
        
        if (!Config::get('config_password')):
            Response::redirect(Url::link('common/login', '', 'SSL'));
        endif;
        
        if (isset($this->request->get['code'])):
            $code = $this->request->get['code'];
        else:
            $code = '';
        endif;
        
        Theme::model('people/user');
        
        $user_info = $this->model_people_user->getUserByCode($code);
        
        if ($user_info):
            $data = Theme::language('common/reset');
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
                $this->model_people_user->editPassword($user_info['user_id'], $this->request->post['password']);
                $this->session->data['success'] = Lang::get('lang_text_success');
                Response::redirect(Url::link('common/login', '', 'SSL'));
            endif;
            
            Breadcrumb::add('lang_text_reset', 'common/reset');
            
            if (isset($this->error['warning'])):
                $data['error_warning'] = $this->error['warning'];
            else:
                $data['error_warning'] = '';
            endif;
            
            if (isset($this->session->data['success'])):
                $data['success'] = $this->session->data['success'];
                unset($this->session->data['success']);
            else:
                $data['success'] = '';
            endif;
            
            if (isset($this->error['password'])):
                $data['error_password'] = $this->error['password'];
            else:
                $data['error_password'] = '';
            endif;
            
            if (isset($this->error['confirm'])):
                $data['error_confirm'] = $this->error['confirm'];
            else:
                $data['error_confirm'] = '';
            endif;
            
            $data['action'] = Url::link('common/reset', 'code=' . $code, 'SSL');
            $data['cancel'] = Url::link('common/login', '', 'SSL');
            
            if (isset($this->request->post['password'])):
                $data['password'] = $this->request->post['password'];
            else:
                $data['password'] = '';
            endif;
            
            if (isset($this->request->post['confirm'])):
                $data['confirm'] = $this->request->post['confirm'];
            else:
                $data['confirm'] = '';
            endif;
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            $data = Theme::renderControllers($data);
            
            Response::setOutput(Theme::view('common/reset', $data));
        else:
            Theme::model('setting/setting');
            $this->model_setting_setting->editSettingValue('config', 'config_password', '0');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            return new Action('common/login');
        endif;
    }
    
    protected function validate() {
        if ((Encode::strlen($this->request->post['password']) < 4) || (Encode::strlen($this->request->post['password']) > 20)):
            $this->error['password'] = Lang::get('lang_error_password');
        endif;
        
        if ($this->request->post['confirm'] != $this->request->post['password']):
            $this->error['confirm'] = Lang::get('lang_error_confirm');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
