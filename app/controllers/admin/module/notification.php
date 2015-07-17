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

namespace App\Controllers\Admin\Module;

use App\Controllers\Controller;

class Notification extends Controller {
	
    private $error;

	public function index() {
		Lang::load('module/notification');
		Theme::setTitle(Lang::get('lang_heading_title'));

		Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
	}

	public function insert() {
		Lang::load('module/notification');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/notification');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            ModuleNotification::addNotification(Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])):
                $url.= '&page=' . Request::p()->get['page'];
            endif;
            
            Response::redirect(Url::link('module/notification', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	public function update() {
		Lang::load('module/notification');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/notification');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            ModuleNotification::editNotification(Request::p()->get['notification_id'], Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';

            if (isset(Request::p()->get['page'])):
                $url.= '&page=' . Request::p()->get['page'];
            endif;
            
            Response::redirect(Url::link('module/notification', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	public function delete() {
		Lang::load('module/notification');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/notification');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()):
            foreach (Request::p()->post['selected'] as $notification_id):
                ModuleNotification::deleteNotification($notification_id);
            endforeach;
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])):
                $url.= '&page=' . Request::p()->get['page'];
            endif;
            
            Response::redirect(Url::link('module/notification', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
	}

	public function getList() {
		$data = Theme::language('module/notification');
		Theme::model('module/notification');

		$url = '';

		if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        	$url .= '&page=' . Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        Breadcrumb::add('lang_heading_title', 'module/notification', $url);
        
        $data['insert'] = Url::link('module/notification/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('module/notification/delete', '' . $url, 'SSL');

        $data['notifications'] = array();
        
        $filter = array( 
            'start' => ($page - 1) * Config::get('config_admin_limit'), 
            'limit' => Config::get('config_admin_limit')
        );
        
		$total   = ModuleNotification::getTotalNotifications();
		$results = ModuleNotification::getNotifications($filter);

		foreach ($results as $result):
            $action = array();
            
            $action[] = array(
            	'text' => Lang::get('lang_text_edit'), 
            	'href' => Url::link('module/notification/update', '' . 'notification_id=' . $result['email_id'] . $url, 'SSL')
            );

            // Let's display a nice name
			$split = explode('_', $result['email_slug']);

			foreach($split as $key => $value):
				$split[$key] =  ucfirst($value);
			endforeach;

			$name = implode(' ', $split);

            $type     = ($result['is_system']) ? Lang::get('lang_text_system') : Lang::get('lang_text_user');
            $priority = ($result['priority'] == 1) ? Lang::get('lang_text_immediate') : Lang::get('lang_text_queue');
            
            $data['notifications'][] = array(
                'notification_id' => $result['email_id'],
                'name'            => $name, 
                'email_slug'      => $result['email_slug'],
                'priority'        => $priority,
                'type'            => $type,
                'is_system'       => $result['is_system'],
                'selected'        => isset(Request::p()->post['selected']) && in_array($result['email_id'], Request::p()->post['selected']), 
                'action'          => $action
            );
        endforeach;

        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $url = '';

        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;

        $data['pagination'] = Theme::paginate(
        	$total, 
        	$page, 
        	Config::get('config_admin_limit'), 
        	Lang::get('lang_text_pagination'), 
        	Url::link('module/notification', '' . $url . '&page={page}', 'SSL')
        );

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('module/notification_list', $data));
	}

	public function getForm() {
		$data = Theme::language('module/notification');
		Theme::model('module/notification');

		if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;

        if (isset($this->error['subject'])):
            $data['error_subject'] = $this->error['subject'];
        else:
            $data['error_subject'] = '';
        endif;

        if (isset($this->error['email_slug'])):
            $data['error_email_slug'] = $this->error['email_slug'];
        else:
            $data['error_email_slug'] = '';
        endif;
        
        if (isset($this->error['error_text'])):
            $data['error_text'] = $this->error['text'];
        else:
            $data['error_text'] = array();
        endif;
        
        if (isset($this->error['html'])):
            $data['error_html'] = $this->error['html'];
        else:
            $data['error_html'] = array();
        endif;

        if (isset($this->error['description'])):
            $data['error_description'] = $this->error['description'];
        else:
            $data['error_description'] = '';
        endif;

        $url = '';
        
        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;
        
        Breadcrumb::add('lang_heading_title', 'module/notification', $url);

        if (!isset(Request::p()->get['notification_id'])):
            $data['action'] = Url::link('module/notification/insert', '' . $url, 'SSL');
        else:
            $data['action'] = Url::link('module/notification/update', '' . 'notification_id=' . Request::p()->get['notification_id'] . $url, 'SSL');
        endif;
        
        $data['cancel'] = Url::link('module/notification', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['notification_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')):
            $notification_info = ModuleNotification::getNotification(Request::p()->get['notification_id']);
        endif;
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['email_content'])):
            $data['email_content'] = Request::p()->post['email_content'];
        elseif (isset(Request::p()->get['notification_id'])):
            $data['email_content'] = ModuleNotification::getNotificationContent(Request::p()->get['notification_id']);
        else:
            $data['email_content'] = array();
        endif;

        if (isset(Request::p()->post['email_slug'])):
            $data['email_slug'] = Request::p()->post['email_slug'];
        elseif (!empty($notification_info)):
            $data['email_slug'] = $notification_info['email_slug'];
        else:
            $data['email_slug'] = '';
        endif;

        if (isset(Request::p()->post['is_system'])):
        	$data['is_system'] = Request::p()->post['is_system'];
        elseif (!empty($notification_info)):
            $data['is_system'] = $notification_info['is_system'];
        else:
            $data['is_system'] = 0;
        endif;

        if (isset(Request::p()->post['configurable'])):
            $data['configurable'] = Request::p()->post['configurable'];
        elseif (!empty($notification_info)):
            $data['configurable'] = $notification_info['configurable'];
        else:
            $data['configurable'] = 0;
        endif;

        if (isset(Request::p()->post['config_description'])):
            $data['config_description'] = Request::p()->post['config_description'];
        elseif (!empty($notification_info)):
            $data['config_description'] = $notification_info['config_description'];
        else:
            $data['config_description'] = '';
        endif;

        // Customer: 1  Admin: 2
        if (isset(Request::p()->post['recipient'])):
            $data['recipient'] = Request::p()->post['recipient'];
        elseif (!empty($notification_info)):
            $data['recipient'] = $notification_info['recipient'];
        else:
            $data['recipient'] = 1;
        endif;

        if (isset(Request::p()->post['priority'])):
            $data['priority'] = Request::p()->post['priority'];
        elseif (!empty($notification_info)):
            $data['priority'] = $notification_info['priority'];
        else:
            $data['priority'] = 2;
        endif;

        Theme::loadjs('javascript/module/notification_form', $data);

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('module/notification_form', $data));

	}

	private function validateForm() {
		if (!User::hasPermission('modify', 'module/notification')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        foreach (Request::p()->post['email_content'] as $language_id => $value):
            if (Encode::strlen($value['text']) < 1):
                $this->error['text'][$language_id] = Lang::get('lang_error_text');
            endif;
            
            if (Encode::strlen($value['html']) < 1):
                $this->error['html'][$language_id] = Lang::get('lang_error_html');
            endif;

            if (Encode::strlen($value['subject']) < 1):
                $this->error['subject'][$language_id] = Lang::get('lang_error_subject');
            endif;
        endforeach;
        
        if (isset(Request::p()->post['email_slug']) && Encode::strlen(Request::p()->post['email_slug']) < 1):
            $this->error['email_slug'] = Lang::get('lang_error_email_slug');
        endif;

        if (Request::p()->post['configurable'] === true && Encode::strlen(Request::p()->post['config_description']) < 3):
            $this->error['description'] = Lang::get('lang_error_description');
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = Lang::get('lang_error_warning');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}

	private function validateDelete() {
		if (!User::hasPermission('modify', 'module/notification')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;

        $count = 0;

        foreach (Request::p()->post['selected'] as $email_id):
        	$check = ModuleNotification::checkSystem($email_id);
        	if ($check):
        		$count++;
        	endif;
        endforeach;

        if ($count > 0):
        	$this->error['warning'] = Lang::get('lang_error_system');
        endif;

        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}
}
